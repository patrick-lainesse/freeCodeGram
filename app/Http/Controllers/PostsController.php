<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    // Makes all of the methods in the class require authorisation
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Displays posts made by followed profiles in decreasing order, 5 per page
    public function index()
    {
        // We connect to users we are following through their profile, but the posts are associated to users, not profiles
        $users = auth()->user()->following()->pluck('profiles.user_id');

        // with('user') refers to Post model user, and is there to optimize queries to the database (which shows with a limit 1 on Telescope)
        //$posts = Post::whereIn('user_id', $users)->orderBy('created_at', 'DESC')->get();
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index', compact('posts'));
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

    // composer require intervention/image to use Intervention\Image class and make the image fit to these dimensions (cut the excess)
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        // Tells Laravel to fetch the user ID that is posting this picture
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        // Die and dump, to return all the data on the page
        //dd(request()->all());

        return redirect('/profile/' . auth()->user()->id);
    }

    /* If we pass the model as a parameter as well, Laravel will show the entire post instead of only its id
        (and it also automatically do a findOrFail) */
    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post'));
        /* is the same thing as:
        return view('posts.show', [
            'post' => $post
        ]);*/
    }
}
