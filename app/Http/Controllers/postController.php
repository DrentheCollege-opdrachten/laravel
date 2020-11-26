<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class postController extends Controller
{

    public function createPost(Request $request, $bandId) {
        $video_url = $request['url'];

        $vars = parse_url($video_url);

        $video_id = ltrim($vars['path'], '/');
        if (isset($vars['query'])) {
            parse_str($vars['query'], $args);
            $video_id = $args['v'];
        }

        $post = Post::create([
            'band_id' => $bandId,
            'video_url' => $video_id
        ]);

        return back();
    }

    public function deletePost($bandId, $postId) {
        Post::where('id', $postId)->delete();
        return back();
    }
}
