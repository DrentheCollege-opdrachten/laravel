<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\NewEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', new NewEmail()],
            'background' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/']
        ]);



        $user->name = $request->name;

        if (isset($request->image)) {
            $img_name = isset($user->profile_image) ? uniqid('profile_picture_').".jpg" : basename($user->profile_img);
            $user->profile_image = $request->image->storeAs('images/users', $img_name);
        }
        $user->theme = json_encode([ "theme" => [
            "background-color" => $request->background,
            "color" => $request->text]
        ]
        );

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
        $user = User::where('id',$id)->first();

        $bands = $user->getBands()->get();

        $posts = [];
        foreach($bands as $band) {
            $posts = array_merge($posts, $band->getPosts()->get()->toArray());
        }
        $posts = json_encode($posts);


        return view('user.index', ['user' => $user, 'bands' => $bands, 'posts' => $posts]);

    }

    public function searchForUser($username) {
        if (strlen($username) < 1) {
            return "[]";
        }
        $users = User::select('name AS label', 'id AS value')->where('name', 'like', "%$username%")->get();
        return json_encode($users);
    }

}
