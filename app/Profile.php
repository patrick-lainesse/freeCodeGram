<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    // disabling out of the box protection to allow update in ProfilesController
    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : '/profile/avatar.jpg';
        return '/storage' . $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
