@extends('layouts.app')

@section('content')
    <div id="home" >
        <div class="d-flex justify-content-center align-items-center guestBackground blurbackground">
            <div class="container">
                <h1 class="row-padding"
                    style="
                        color:white;
                        text-align:center;
                        letter-spacing:.15em;">
                    Zoek hier het profiel van een band!</h1>
                <form action="/search" method="POST">
                    @csrf
                    <input type="text" class="form-control guestSearch" placeholder=" " name="query">
                    <div class="cursor"></div>
                    <button type="submit" class="btn btn-default"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                        </svg></button>
                </form>
            </div>
        </div>
    </div>
@endsection
