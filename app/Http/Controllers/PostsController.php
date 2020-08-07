<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    // Makes all of the methods in the class require authorisation
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            // If another field was needed for the create method below, we could an empty parameter here: 'another' => '',
           'caption' => 'required',
           'image' => ['required', 'image']
        ]);

        // Tells Laravel to fetch the user ID that is posting this picture
        auth()->user()->posts()->create($data);

        dd(request()->all());
    }
}
