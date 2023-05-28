<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFilterRequest;
use App\Http\Requests\FormPostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function create()
    {
        $post= new Post();
        $post->title='hello';
        return \view('blog.create', [
            'post'=> $post
        ]);
    }

    public function store(FormPostRequest $request) {
        $post= Post::create($request->validated());

       return redirect()->route('blog.show', ['slug'=>$post->slug, 'post'=> $post->id])->with('succes',"L 'article a bien été sauvegardé"  );
    }

    public function edit(Post $post) {
        return view('blog.edit', [
            'post'=> $post
        ]);
    }

    public function update(Post $post, FormPostRequest $request){
        $post->update($request->validated());

        return redirect()->route('blog.show', ['slug'=>$post->slug, 'post'=> $post->id])->with('succes',"L 'article a bien été modifié"  );




    }
    public function index(BlogFilterRequest $request): View{

      return view('blog.index', [
          'posts'=>  Post::paginate(2)

        ]);
    }

    public function show( string $slug, Post $post, Request $request): RedirectResponse |View {


        if ($post->slug !== $slug){

            return to_route('blog.show', ['slug'=>$post->slug, 'id'=> $post->id]);
        }

        return view('blog.show', [
            'post'=> $post
        ]) ;
    }
}

