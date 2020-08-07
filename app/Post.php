<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Tells Laravel that it's ok to not guard anything, since it is being handled by us
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
