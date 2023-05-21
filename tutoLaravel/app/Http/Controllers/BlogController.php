<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View{
      return view('blog.index', [
          'posts'=>  Post::paginate(2)

        ]);
    }

    public function show(string $slug, string $id): RedirectResponse | View
    {

        $post= \App\Models\Post::findorFail($id);
        if ($post->slug !== $slug){

            return to_route('blog.show', ['slug'=>$post->slug, 'id'=> $post->id]);
        }
        return view('blog.show', [
            'post'=> $post
        ]) ;
    }
}

