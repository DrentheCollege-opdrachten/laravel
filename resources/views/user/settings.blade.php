@extends('layouts.app')

@section('content')

<div class="container">
    <div id="user-settings">
        <form action="{{ route('user.settings.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-fluid">
                <!-- .card-body -->
                <h3 class="card-header">{{auth()->user()->name}}</h3>
                <div class="card-body">


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>
                                there has been an error updating the settings
                            </h6>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                @endif
                    <!-- form -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="input01" class="col-md-3">Cover image</label>
                            <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="input01" multiple="" name="image">
                                    <label class="custom-file-label" for="input01">Choose cover</label>
                                </div>
                                <small class="text-muted">Upload a new cover image, JPG 1200x300</small>
                            </div>
                            <!-- /form column -->
                        </div>
                        <!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="input02" class="col-md-3">Name</label>
                            <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control" id="input02" value="{{ old('name', auth()->user()->name)}}" name="name">
                            </div>
                            <!-- /form column -->
                        </div>

                    <div class="form-row">
                        <!-- form column -->
                        <label for="input12" class="col-md-3">Email</label>
                        <!-- /form column -->
                        <!-- form column -->
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control" id="input12" value="{{ old('email', auth()->user()->email)}}" name="email">
                        </div>
                        <!-- /form column -->
                    </div>
                        <!-- /form row -->
                        <!-- form row -->
                        <div class="form-row">
                            <!-- form column -->
                            <label for="input03" class="col-md-3">Biography</label>
                            <!-- /form column -->
                            <!-- form column -->
                            <div class="col-md-9 mb-3">
                                <textarea type="text" class="form-control" id="input03" name="bio" rows="8">{{old('bio', auth()->user()->bio)}}</textarea>
                                <small class="text-muted">Appears on your profile page, 225 chars max.</small>
                            </div>
                            <!-- /form column -->
                        </div>
                        <!-- /form row -->
                    <!-- form row -->
                    <div class="form-row">
                        <!-- form column -->
                        <label for="input04" class="col-md-3">Background Color</label>
                        <!-- /form column -->
                        <!-- form column -->
                        <div class="col-md-9 mb-3">
                            <div class="custom-control custom-checkbox">
                                <?php
                                    $theme = is_array(auth()->user()->theme) ? auth()->user()->theme : json_decode(auth()->user()->theme, true);
                                ?>

                                <input type="color" id="input04" class="col-md-12" name="background" value="{{$theme["theme"]["background-color"]}}">
                            </div>
                        </div>
                        <!-- /form column -->
                    </div>
                    <!-- /form row -->
                    <!-- form row -->
                    <div class="form-row">
                        <!-- form column -->
                        <label for="input05" class="col-md-3">Text Color</label>
                        <!-- /form column -->
                        <!-- form column -->
                        <div class="col-md-9 mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="color" id="input05" class="col-md-12" name="text" value="{{$theme["theme"]["color"] ?? "#000000"}}">
                            </div>
                        </div>
                        <!-- /form column -->
                    </div>
                    <!-- /form row -->
                        <hr>
                        <!-- .form-actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn ml-auto">Update Profile</button>
                        </div>
                        <!-- /.form-actions -->
                    <!-- /form -->
                </div>
                <!-- /.card-body -->
            </div>
        </form>
    </div>
</div>
@endsection

@push('head')
    <script>
        document.documentElement.style.setProperty('--background-color', '{{$theme["theme"]["background-color"]}}');
        document.documentElement.style.setProperty('--text-color', '{{$theme["theme"]["color"]}}');
    </script>

@endpush
