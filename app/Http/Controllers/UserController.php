<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\User;
use App\Rules\NewEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * change the users settings
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeSettingsPost(Request $request) {

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', new NewEmail()],
            'bio' =>['required', 'max:225'],
            'background' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/']
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validate();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->bio = $data["bio"];


        if (isset($request->image)) {
            $img_name = isset($user->profile_image) ? uniqid('profile_picture_').".jpg" : basename($user->profile_img);
            $user->profile_image = $request->image->storeAs('users', $img_name, 'profileImages');
        }
        $theme = json_encode([ "theme" => [
            "background-color" => $request->background,
            "color" => $request->text]
        ]);
        $user->theme = $theme;

        $user->save();

        return back();
    }
    public function changeSettingsGet() {
        return view('user.settings');
    }

    /**
     *
     * Show your or another users home page
     */
    public function index($id = null)
    {

        if ($id == null) {
            $id = Auth::id();
            if ($id == null) {
                return view('auth.login');
            }
        }
        if (User::find($id) == null) {
            return abort(404);
        }
        $user = User::where('id',$id)->first();

        $bands = $user->getBands()->latest()->get();

        $postsArrToView = [];
        foreach($bands as $band) {
            $posts = $band->getPosts()->get();

            $postsArr = [];
            for($i=0; $i < count($posts); $i++) {
                $post = $posts[$i];
                $post->band = Band::where('id',$post->band_id)->get()[0]->name;

                $postsArr[$i] = $post->toArray();
            }
            $postsArrToView = array_merge($postsArrToView, $postsArr);
        }

        usort($postsArrToView, 'App\Http\Controllers\date_compare');

        $postsArrToView = json_encode(array_slice(array_reverse($postsArrToView), 0, 4));


        return view('user.index', [
            'type' => "user",
            'user' => $user,
            'bands' => $bands,
            'posts' => $postsArrToView]);

    }

}

function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['updated_at']);
    $datetime2 = strtotime($element2['updated_at']);
    return $datetime1 - $datetime2;
}
