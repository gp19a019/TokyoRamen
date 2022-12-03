<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['name', 'image', 'review', 'points'];
    protected $casts = [
        'points' => 'integer',
    ];
    protected $dates = [
        'created'
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function favorite(){
        return $this->belongsTo('App\Favorite');
    }

    public function store(){
        return $this->hasMany('App\Store');
    }
}
