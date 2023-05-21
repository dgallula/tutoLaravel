
@extends('base')

@section('title', 'accueil')

@section('content')
  <h1>Mon blog</h1>

    @foreach($posts as $post)
        <a>
            <h2>{{ $post->title }}</h2>

            <p>
                {{ $post->content }}
            </p>
            <a href="{{ route('blog.show', [ 'slug'=>$post->slug, 'id'=>$post->id]) }}" class="btn btn-primary">lire la suite</a>
        </article>

    @endforeach

    {{$posts->links()}}


@endsection

