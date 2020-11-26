<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BandController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($id == null || Band::find($id) == null) {
            return abort(404);
        }


        $band = Band::find($id);
        $posts = $band->getLatestPosts()->get();
        $members = $band->getMembers()->oldest()->get();


//        $members = json_encode($members);
        $posts = json_encode($posts);

//        dd($members);
        return view('user.index', [
            'type' => 'band',
            'user' => $band,
            'bands' => $members,
            'posts' => $posts,
            'request' => $request]);
    }

    /**
     * Create a new band
     */
    public function createBandGet() {
        return view('bands.create');
    }
    public function createBandPut(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'image' => 'required'
        ]);


        $url = $request["image"]->storeAs('bands', uniqid('profile_picture_').".jpg", 'profileImages');
        $band = Band::create([
            'name' => $data['name'],
            'bio' => $data["bio"],
            'profile_image' => $url,
            'theme' => '{"theme": {"background-color": "#ffffff", "color":"#000000"}}'
        ]);

        $band->addMember(Auth::user());

        return redirect("/band/{$band->id}");
    }

    /**
     * Functions for the band settings route
     */
    public function changeSettingsGet($bandId) {
        return view('bands.settings', ['band' => Band::find($bandId)]);
    }
    public function changeSettingsPost(Request $request, $bandId) {
        $data = $request->validate([
           'name' => 'required',
            'bio' => ['required', 'max:300'],
            'background' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/']
        ]);

        $band = Band::find($bandId);

        $band->name = $data['name'];
        $band->bio = $data['bio'];

        $band->theme = json_encode([ "theme" => [
            "background-color" => $request->background,
            "color" => $request->text]
        ]);

        if (isset($request->image)) {
            $band->saveProfileImage($request->image);
        }
        $band->save();
        return back();
    }

    /**
     * Function for the routes to manipulate the band users
     */
    public function addBandUser($bandId, $user_id) {
        Band::find($bandId)->addMember($user_id);
        return "";
    }
    public function getMembers($bandId) {
        return Band::find($bandId)->getMembers;
    }
    public function removeMember($bandId, $user_id) {
        Band::find($bandId)->removeMember($user_id);
        return "";
    }


}
