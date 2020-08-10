<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        return view('profiles.index', compact('user'));
    }

    // Since we are importing App\User, we can replace \App\User $user with User $user
    public function edit(User $user)
    {
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        // validation
        $data = request()->validate([
           'title' => 'required',
           'description' => 'required',
           'url' => 'url',
           'image'=> '',
        ]);

        // auth() add an extra level of protection to make sure an unregistred user can't change another user's profile
        auth()->$user->profile()->update($data);

        return redirect("/profile/{$user->id}");
    }
}
