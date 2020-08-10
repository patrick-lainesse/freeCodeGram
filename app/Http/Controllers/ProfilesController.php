<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        return view('profiles.index', compact('user'));
    }

    // Since we are importing App\User, we can replace \App\User $user with User $user
    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        // validation
        $data = request()->validate([
           'title' => 'required',
           'description' => 'required',
           'url' => 'url',
           'image'=> '',
        ]);

        // If there is an image in the request
        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath]; // overrides what was stored in $data for 'image'
        }

        // auth() add an extra level of protection to make sure an unregistred user can't change another user's profile
        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []   // if imageArray is not set, it defaults to an empty array to avoid deleting image when none is uploaded
        ));

        return redirect("/profile/{$user->id}");
    }
}
