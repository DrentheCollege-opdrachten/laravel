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
    <form action="{{ route('bands.settings.submit', ['bandId' => $band->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1> Band </h1>

        <input id="name" type="text" class="form-control" name="name" placeholder="name">
        <input id="bio" type="text" class="form-control" name="bio" placeholder="bio">
        <div id="autoCompleteInput" data-type="user"></div>
        <input type="file" name="image" class="form-control">
        <input type="color" name="background" class="form-controll">
        <input type="color" name="text" class="form-controll">

        <button type="submit" class="btn btn-success">Upload</button>

    </form>



@endsection
