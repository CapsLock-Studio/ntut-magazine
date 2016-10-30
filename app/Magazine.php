<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Magazine extends Model implements StaplerableInterface {

    use EloquentTrait;

    protected $fillable = ['image', 'title'];

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('image', [
            'styles' => [
                'large' => '1920',
                'medium' => '960',
                'thumb' => '240',
            ],
            'default_url' => 'https://placeholdit.imgix.net/~text?txtsize=33&txt=Image&w=400&h=400'
        ]);

        parent::__construct($attributes);
    }
}
