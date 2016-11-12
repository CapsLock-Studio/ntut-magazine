<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class News extends Model implements StaplerableInterface {
    use EloquentTrait;

    protected $fillable = ['title', 'content', 'publishedAt', 'cover', 'showCover'];

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('cover', [
            'styles' => [
                'large' => '973x615#',
                'medium' => '486.5x307.5#',
                'thumb' => '78x49.3#',
            ],
            'default_url' => 'https://placeholdit.imgix.net/~text?txtsize=90&txt=973x615&w=973&h=615'
        ]);

        parent::__construct($attributes);
    }

    public function setShowCoverAttribute($value)
    {
        $this->attributes['showCover'] = $value == 'on' ? true : false;
    }

    public function getPublishedAtAttribute($value)
    {
        return new Carbon($value);
    }
}
