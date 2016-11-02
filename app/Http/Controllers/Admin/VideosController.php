<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use PulkitJalan\Google\Facades\Google;
use App\GoogleAuth;
use App\Video;

class VideosController extends Controller
{
    public function index(Request $request)
    {
        // If there is no any token show get auth modal,
        // If the token has expired, show get auth modal.
        $token = $request->session()->get('token');

        if (!empty($token)) {
            $client = Google::getClient();
            $client->setAccessToken($token);

            $youtube = new \Google_Service_YouTube($client);

            try {
                // Call the channels.list method to retrieve information about the
                // currently authenticated user's channel.
                $channelsResponse = $youtube->channels->listChannels('contentDetails', [ 'mine' => 'true' ]);

                $videoIdsFromApi = [];

                foreach ($channelsResponse['items'] as $channel) {
                    // Extract the unique playlist ID that identifies the list of videos
                    // uploaded to the channel, and then call the playlistItems.list method
                    // to retrieve that list.
                    $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];

                    $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', [
                        'playlistId' => $uploadsListId,
                        'maxResults' => 50
                    ]);

                    foreach ($playlistItemsResponse['items'] as $playlistItem) {
                        $videoId = $playlistItem['snippet']['resourceId']['videoId'];
                        $videoIdsFromApi[] = $videoId;

                        $video = Video::where('youtubeId', $videoId)->first();

                        if (empty($video)) {
                            $video = new Video;
                            $video->youtubeId = $videoId;
                        }

                        $video->title = $playlistItem['snippet']['title'];
                        $video->thumbnailUrl = $playlistItem['snippet']['thumbnails']['high']['url'];

                        $video->save();
                    }
                }

                $youtubeIdsFromDB = Video::select('youtubeId')->get()->map(function($video) { return $video->youtubeId; })->toArray();

                $idsNeedToDelete = array_diff($youtubeIdsFromDB, $videoIdsFromApi);

                Video::whereIn('youtubeId', $idsNeedToDelete)->delete();

            } catch (\Google_Service_Exception $e) {
                $request->session()->set('token', null);
            } catch (\Google_Exception $e) {
                $request->session()->set('token', null);
            }
        }

        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));
    }

    public function create(Request $request)
    {
        $token = $request->session()->get('token');
        $categories = [];

        if (!empty($token)) {
            try {
                $client = Google::getClient();
                $client->setAccessToken($token);

                $youtube = new \Google_Service_YouTube($client);
                $categoriesResponse = $youtube->videoCategories->listVideoCategories('snippet', [ 'hl' => 'zh-TW', 'regionCode' => 'TW' ]);

                $categories = array_map(function($category) {
                    return [ 'categoryId' => $category['id'], 'categoryName' => $category['snippet']['title'] ];
                }, $categoriesResponse['items']);

            } catch (\Google_Service_Exception $e) {
                $request->session()->set('token', null);
            } catch (\Google_Exception $e) {
                $request->session()->set('token', null);
            }
        }

        view()->share('video', new Video);
        view()->share('categories', $categories);
    }

    public function edit(Request $request, $id)
    {

    }

    public function store(Request $request)
    {
        $token = $request->session()->get('token');

        if (empty($token)) {
            $request->session()->flash('flashMessage', 'Google 授權失敗，請重新授權。');
            $request->session()->flash('flashStatus', 'danger');

            return redirect()->action('Admin\VideosController@index');
        }

        try {
            $client = Google::getClient();
            $client->setAccessToken($token);

            $youtube = new \Google_Service_YouTube($client);

            $snippet = new \Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle($request->title);
            $snippet->setDescription($request->description);
            $snippet->setCategoryId($request->categoryId);

            $status = new \Google_Service_YouTube_VideoStatus();
            $status->privacyStatus = 'public';

            $video = new \Google_Service_YouTube_Video();
            $video->setSnippet($snippet);
            $video->setStatus($status);

            $chunkSizeBytes = 1 * 1024 * 1024;

            $client->setDefer(true);

            $insertRequest = $youtube->videos->insert('status,snippet', $video);

            $media = new \Google_Http_mediaFileUpload(
                $client,
                $insertRequest,
                'video/*',
                null,
                true,
                $chunkSizeBytes
            );

            $video = $request->file('video');

            $media->setFileSize(filesize($video->path()));

            $status = false;
            $handle = fopen($video->path(), 'rb');
            while (!$status && !feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                $status = $media->nextChunk($chunk);
            }

            fclose($handle);

            $client->setDefer(false);

            $request->session()->flash('flashMessage', "上傳 YouTube 成功，{$status['id']} - {$status['snippet']['title']}");
            $request->session()->flash('flashStatus', 'success');

            return redirect()->action('Admin\VideosController@index');

        } catch (\Google_Service_Exception $e) {
            $request->session()->set('token', null);

            $request->session()->flash('flashMessage', 'Google 授權失敗，請重新授權。');
            $request->session()->flash('flashStatus', 'danger');

            return redirect()->action('Admin\VideosController@index');
        } catch (\Google_Exception $e) {
            $request->session()->set('token', null);

            $request->session()->flash('flashMessage', 'Google 授權失敗，請重新授權。');
            $request->session()->flash('flashStatus', 'danger');

            return redirect()->action('Admin\VideosController@index');
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $id)
    {

    }
}
