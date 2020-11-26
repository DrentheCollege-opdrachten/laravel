@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content" id="search">
            <div class="bands row">
                @foreach ($bands as $band)
                    <div class="card col-md-6" style="margin-bottom: 10px">
                        <img src="{{asset('profileImages/'.$band->profile_image)}}" alt="" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{$band->name}}</h5>
                            <p class="card-text">{{$band->bio}}</p>
                            <a href="/band/{{ $band->id }}"  class="btn btn-primary"> Visit band </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
