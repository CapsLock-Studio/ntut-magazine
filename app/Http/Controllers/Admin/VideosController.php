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
                    return [ 'categoryId' => $category['snippet']['channelId'], 'categoryName' => $category['snippet']['title'] ];
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

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $id)
    {

    }
}
