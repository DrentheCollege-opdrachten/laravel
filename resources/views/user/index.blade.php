@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="column">
            {{ $user }}
            <hr />
            {{ $bands }}
            <hr />
            {{ $posts }}
        </div>
    </div>
</div>
@endsection
