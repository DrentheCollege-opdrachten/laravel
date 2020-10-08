<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BandController extends Controller
{
    public function index($id = null)
    {
        if ($id == null) {
            return view('bands.missing');
        }

        $band = Band::find($id);
        $posts = $band->getPosts()->get();
        $members = $band->getMembers()->get();


        $members = json_encode($members);
        $posts = json_encode($posts);
        return view('bands.index', ['band' => $band, 'members' => $members, 'posts' => $posts]);
    }

    public function changeSettingsPost(Request $request, $bandId) {
        $band = Band::find($bandId);
        dd($request);

        /**
         * TODO: Change the values in the database
         */
        return back();
    }

    public function addBandUser($band_id, $user_id) {
        $band = Band::find($band_id);
        $band->addMember($user_id);

        return json_encode($band->getMembers);
    }

    public function changeSettingsGet($bandId) {
        return view('bands.settings', ['band' => Band::find($bandId)]);
    }
}
