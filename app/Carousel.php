<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Carousel extends Model implements StaplerableInterface {
    use EloquentTrait;

    // Add the 'avatar' attachment to the fillable array so that it's mass-assignable on this model.
    protected $fillable = ['image', 'order', 'title'];

    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('image', [
            'styles' => [
                'large' => '1920x800',
                'medium' => '960x400',
                'thumb' => '480x200',
            ],
            'default_url' => 'https://placeholdit.imgix.net/~text?txtsize=33&txt=1920%C3%97800&w=960&h=400',
        ]);

        parent::__construct($attributes);
    }
}