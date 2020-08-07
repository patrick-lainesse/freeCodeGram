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

        /* Stores the picture in the public directory. Could use a driver instead of 'public' (s3, for example) to store on Amazon
            Takes care of all the moving files code in PHP in a single line! */
        $imagePath = request('image')->store('uploads', 'public');

        // Tells Laravel to fetch the user ID that is posting this picture
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        // Die and dump, to return all the data on the page
        //dd(request()->all());

        return redirect('/profile/' . auth()->user()->id);
    }
}
