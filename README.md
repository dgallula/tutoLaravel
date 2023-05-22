# tutoLaravel

# tutoLaravel git 


git add .     
git commit -m "Models controler ok "       
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


chapitre 4 
view

Dans ce chapitre nous allons découvrir la partie vue dans la structure MVC. Laravel dispose d'un moteur de template qui va nous permettre de générer plus simplement des vues HTML.

Les vues blade seront créées dans des fichier avec l'extension .blade.php et on pourra afficher les variables à l'aide d'accolades.

{{ $username }}
Cette méthode, par rapport à l'utilisation de simple <?= ?> permet d'automatiquement échapper les caractères HTML.

Il est aussi possible d'utiliser des conditions et des boucles à l'aide de directives qui seront préfixées par un @.

@if (count($records) === 1)
I have one record!
@elseif (count($records) > 1)
I have multiple records!
@else
I don't have any records!
@endif



lesson 5 

la methode de validation 

Dans ce nouveau chapitre on va découvrir la partie validation avant d'attaquer la gestion des formulaires. Il est important de s'assurer que les données envoyées à notre application correspondent à ce que l'on attend. Pour cela, Laravel nous offre une classe Validator qui va nous permettre de gérer cette opération.

$validator = Validator::make($data, [
'name' => 'required|string'
])
La méthode make() prendra en premier paramètre les données à valider et en second paramètre un tableau représentant les règles de validations.

Il existe plusieurs manières de définir les règles de validation :

Sous forme d'une chaîne de caractères avec les différentes règles séparées par des |.
Sous forme d'un tableau listant l'ensemble des règles (ex : ["required", "min:4"])
En utilisant la classe Illuminate\Validation\Rule pour des règles plus complexes (ex: Rule::dimensions()->maxWidth(1000)->maxHeight(500)->ratio(3 / 2))
A partir de cet objet on peut tester l'état de notre validation à l'aide de différentes méthodes.

La méthode fails() renvoie un booléen pour savoir si une validation a échoué ou non
La méthode errors() permet de récupérer les messages d'erreurs associés aux éléments qui ne satisfont pas les règles de validation.
La méthode validated() renvoie un tableau correspondant aux données qui ont été validées (en supprimant les clef qui n'ont pas de règles de validation).
Cette dernière méthode, va aussi renvoyer une exception si les données ne sont pas valides. Ce type d'exception sera automatiquement capturée par le framework qui réagira différemment suivant le type de requêtes.

Dans le cas d'une requête qui attend du JSON, les erreurs seront renvoyés au format JSON.
Dans le cas d'une requête qui attend de l'HTML, la réponse sera une redirection vers la page précédente avec les erreurs et les données soumises sauvegardées en session.
Cette méthode validated() est très intéressante parce qu'elle permet à la fois de s'assurer que les données sont valides pour la suite de l'exécution et permet au framework de gérer les erreurs si c'est nécessaire.

$data = $validator->validated();
// Pour récupérer juste une valeur
$firstname = $validator->validated('firstname');
FormRequest
Si on souhaite valider les paramètres provenant de la requête faite par l'utilisateur (soumission d'un formulaire ou validation de paramètres dans l'URL) il est possible d'utiliser des objets de requête personnalisés. Pour créer une requête on peut utiliser la commande artisan:

php artisan make:request CreatePostRequest
Cette commande va créer automatiquement une nouvelle classe qui possède 2 méthodes :

authorize qui renverra un booléen pour dire si l'utilisateur à le droit ou non de consulter la page (on verra cela plus tard).
rules qui renverra un tableau contenant les règles de validation à satisfaire.
Ensuite, nous pouvons injecter cet objet CreatePostRequest dans notre contrôleur, au lieu de l'objet Request de base.

function store(CreatePostRequest $request) {
$data = $request->validated();
// ...
}
Laravel se chargera automatiquement de valider les données à partir de nos règles et de renvoyer la bonne réponse en cas d'erreur. A l'intérieur de la logique de la fonction on saura que les données sont valide et on pourra continuer son exécution.










