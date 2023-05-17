# tutoLaravel

# tutoLaravel git 


git add .     
git commit -m "ORM eloquent"       
git remote add origin https://github.com/dgallula/tutoLaravel.git
git branch -M master  
git push -u origin master

# tutoLaravel routes


Route::get('/',function () {
return view('welcome');
});

Route::prefix('/blog')->name('blog.')->group(function () {
Route::get('/',function (Request $request ) {
return [
"link"=>\route('blog.show',['slug'=>'article','id'=>13]),
];
})->name('index');


    Route::get('/{slug}-{id}',function (string $slug, string $id, Request $request) {
        return [
            'slug' => $slug,
            'id' => $id,
            'name'=> $request->input('name','David')
        ];

    })->where([
        'id'=>'[0-9]+',
        'slug'=>'[a-z0-9\-]+'
    ])->name('show');


});

lesson 3 ORM eloquent 

php artisan make:migration


        $post = new \App\Models\Post();
        $post->title='Mon second article';
        $post->slug = 'mon-second-article';
        $post->content= "Mon contenu";
        $post->save();

        return $post;

      $posts=  \App\Models\Post::all(['id','title'])
       dd($posts)->first();

 doc : query builder

$posts=  \App\Models\Post::where('id', '>', 0)->limit(2)->get();

mise à jour
$posts=  \App\Models\Post::find(1);
$posts->title='Nouveau titre';
$posts->save();

suprimmer
$posts=  \App\Models\Post::find(1);
$posts->title='Nouveau titre';
$posts->delete();

$posts=  \App\Models\Post::create([
'title'=>'mon nouveau titre',
'slug'=>'nouveau-titre-test',
'content'=>'Nouveau contenu'
]);


orm 

Route::prefix('/blog')->name('blog.')->group(function () {
Route::get('/',function (Request $request ) {

       return $posts=  \App\Models\Post::paginate(25);


    })->name('index');


    Route::get('/{slug}-{id}',function (string $slug, string $id, Request $request) {
        $post= \App\Models\Post::findorFail($id);
        if ($post->slug !== $slug){

            return to_route('blog.show', ['slug'=>$post->slug, 'id'=> $post->id]);
        }
        return $post;
        return [
            'slug' => $slug,
            'id' => $id,
            'name'=> $request->input('name','David')
        ];

    })->where([
        'id'=>'[0-9]+',
        'slug'=>'[a-z0-9\-]+'
    ])->name('show');


});
















