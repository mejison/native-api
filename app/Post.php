<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $casts = [
        "location" => "array"
    ];

    public function images() {
        return $this->hasMany("App\PostImage", "post_id");
    }

    public function user() {
        return $this->hasOne("App\User", "id", "user_id");
    }
}