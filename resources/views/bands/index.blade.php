@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="column">
                {{ $band }}
                <hr />
                {{ $members }}
                <hr />
                {{ $posts }}
            </div>
        </div>
    </div>
@endsection
