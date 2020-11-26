@extends('layouts.app')

@section('content')
<div id="userPage" class="container">
    <div class="row justify-content-center">
        <div class="column col-md-12">

            <div class="card mb-12 customGradient">
                <div class="row no-gutters">
                    <div class="col-md-6 col-sm-12">
                        <img width="100%" src="{{asset('profileImages/'.$user->profile_image)}}" />

                    </div>
                    <div class="col-md-6 col-sm-12 sixteenByNine">
                        <div class="card-body aspect-ratio-body">
                            <h3 class="card-title"> {{ $user->name }} </h3>
                            <p class="card-text"> {{ $user->bio }} </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($type == "band")
                @if(Auth::check() && Auth::user()->inBand($user->id))
                    <form method="POST" action="{{ route('createPost', ['bandId' => $user->id]) }}">
                        @csrf
                        <label for="url">
                            <h3> Add a post </h3>
                        </label>
                        <input type="url" placeholder="https://www.youtube.com" name="url" />
                    </form>

                    <a href="{{ route('bands.settings', ['bandId' => $user->id ]) }}">
                        Settings
                    </a>

                @endif
            @endif

            <h2 class="underline"> {{ $type=="band" ? "Members" : "Bands" }} </h2>
            <div class="row bands">
                @if(count($bands) <= 0)
                    @if($type == "band")
                        <h4 style="margin:20px"> There are no members in this band</h4>
                    @else
                        <h4 style="margin:20px"> This user is not part of a band</h4>
                    @endif
                @endif

                @foreach($bands as $band)
                    <a class="card band col-md-3" href="{{route('band', ['bandId' => $band->id])}}">
                        <div class="card-img square-image col-md-12">
                            <div class="image" style='background-image: url("{{asset('profileImages/'.$band->profile_image ?? "default.jpg")}}")'></div>
                            <img src=""/>
                        </div>
                        <div class="card-img-overlay">
                            <h5 class="card-title">{{ $band->name }}</h5>
                            <p class="card-text">{{ $band->bio }}</p>
                        </div>
                    </a>

                @endforeach
            </div>

            <h2 class="underline"> Songs </h2>

            <div class="row posts">
                <?php $posts = json_decode($posts, true) ?>
                @if(count($posts) <= 0)
                    @if($type == "band")
                        <h4 style="margin:20px"> This band has no posts yet</h4>
                    @else
                        <h4 style="margin:20px"> This user has no posts yet</h4>
                    @endif
                @endif
                @foreach($posts as $post)
                    <div class="post col-md-6 embed-responsive embed-responsive-16by9">
                        <iframe
                            class="content"
                            src="https://www.youtube.com/embed/{{$post['video_url']}}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                        @if($type == "band")
                            @if(Auth::check() && Auth::user()->inBand($user->id))
                                <form
                                    action="{{route('deletePost',['bandId' => $user->id, 'postId' => $post["id"]])}}"
                                    method="DELETE">
                                    <label for="delete{{$post["id"]}}" class="icon-large">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </label>
                                    <input id="delete{{$post["id"]}}" type="submit" class="hidden" name="delete"/>
                                </form>
                            @endif
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


@push('head')
    <?php
    $theme = is_array($user->theme) ? $user->theme : json_decode($user->theme, true);
    ?>
    <script>
        document.documentElement.style.setProperty('--background-color', '{{$theme["theme"]["background-color"]}}');
        document.documentElement.style.setProperty('--text-color', '{{$theme["theme"]["color"]}}');
    </script>

@endpush

