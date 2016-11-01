<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['youtubeId', 'thumbnailUrl', 'title', 'description', 'categoryId', 'categoryName'];
}
