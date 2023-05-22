<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFilterRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(BlogFilterRequest $request): View{

      return view('blog.index', [
          'posts'=>  Post::paginate(2)

        ]);
    }

    public function show(string $slug, string $id): RedirectResponse |View {




        $post= \App\Models\Post::findorFail($id);
        if ($post->slug !== $slug){

            return to_route('blog.show', ['slug'=>$post->slug, 'id'=> $post->id]);
        }
        return view('blog.show', [
            'post'=> $post
        ]) ;
    }
}

