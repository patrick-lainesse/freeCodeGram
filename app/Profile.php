<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    // disabling out of the box protection to allow update in ProfilesController
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
