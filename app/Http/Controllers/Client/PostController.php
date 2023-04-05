<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;
use Database\Seeders\PostSeeder;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $bag = [
            'posts' => News::all()
        ];
        return view("posts", $bag);
    }

    public function show(Request $request)
    {
        $id = $request->id ?? null;
        if ($id == null) {
            return view("errors.404");
        }
        $post = News::find($id) ?? null;
        if ($post == null) {
            return view("errors.404");
        }
        $bag = [
            'post' => $post,
            'posts' => News::orderBy("updated_at", "DESC")->get()
        ];
        return view("post", $bag);
    }
}
