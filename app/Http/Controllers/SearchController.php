<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchBandAndUserByName($name) {
        return [
            "users" => User::select('name', 'id')->where('name', 'like',"%$name%")->get()->toArray(),
            "bands" => Band::select('name', 'id')->where('name', 'like',"%$name%")->get()->toArray()
        ];
    }

    public function searchBandAndUserByNameView(Request $request) {
        $name = $request->name;
        $results = [
            "users" => User::where('name', 'like',"%$name%")->get(),
            "bands" => Band::where('name', 'like',"%$name%")->get()
        ];

        return view('search', $results);
    }

    public function searchForUserByMail($email) {
        if (strlen($email) <= 0) {
            return "[]";
        }
        $users = User::select('email', 'id')->where('name', 'like', "%$email%")->get();
        return json_encode($users);
    }
}
