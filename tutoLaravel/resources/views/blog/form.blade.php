
<form action="" method="post" class="vstack gap-2">
        @csrf
    @method($post->id?  "Patch" : "Post")
        <div class="form-group">
            <input type="text"  class="form-control" name="title" value="{{old('title', $post->title) }}" >
            @error('title')
            {{$message}}
            @enderror
        </div>

    <div class="form-group">
    <input type="slug"  class="form-control" name="slug" value="{{old('slug',$post->slug) }}" >
            @error('slug')
            {{$message}}
            @enderror
    </div>

    <div class="form-group">

        <textarea id="content"  class="form-control" name="content"  >{{old('content', $post->content)}}</textarea>
            @error('content')
            {{$message}}
            @enderror
        </div>
        <button class="btn btn-primary">
    @if($post->id)
       Modifier
    @else
        Creer
    @endif
        </button>

</form>
