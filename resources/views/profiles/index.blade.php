@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 p-5">
                <img
                    src="https://instagram.fyhu2-1.fna.fbcdn.net/v/t51.2885-19/s150x150/97566921_2973768799380412_5562195854791540736_n.jpg?_nc_ht=instagram.fyhu2-1.fna.fbcdn.net&amp;_nc_ohc=LFHchPCFeR0AX_jYfOT&amp;oh=c94ec2a2f75789c25cee3aa04abcdb56&amp;oe=5F56A067"
                    class="rounded-circle" alt="freeCodeCamp logo">
            </div>
            <div class="col-9 pt-5">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h1>{{ $user->username }}</h1>
                    <a href="/p/create">Add New Post</a>
                </div>
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
                <div class="d-flex">
                    <div class="pr-5"><strong>{{ $user->posts->count() }}</strong> posts</div>
                    <div class="pr-5"><strong>23k</strong> followers</div>
                    <div class="pr-5"><strong>212</strong> following</div>
                </div>
                <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
                <div>{{ $user->profile->description }}</div>
                <div><a href="#">{{ $user->profile->url }}</a></div>
            </div>
        </div>

        <div class="row pt-5">
            @foreach($user->posts as $post)
                <div class="col-4 pb-4">
                    <a href="/p/{{ $post->id }}">
                        <img src="/storage/{{ $post->image }}" class="w-100" alt="Post picture">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
