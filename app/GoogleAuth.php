<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleAuth extends Model
{
    protected $fillable = ['token', 'authToken'];

    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = json_encode($value);
    }

    public function getTokenAttribute($value)
    {
        return json_decode($value);
    }
}
