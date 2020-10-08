@extends('layouts.app')

@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('user.settings.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}">
        <input id="email" type="text" class="form-control" name="email" value="{{ old('email', auth()->user()->email) }}">
        <input type="file" name="image" class="form-control" value="{{ old('profile_image', auth()->user()->profile_image) }}">
        <input type="color" name="background" class="form-controll">
        <input type="color" name="text" class="form-controll">

        <button type="submit" class="btn btn-success">Upload</button>


    </form>
