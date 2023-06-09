# tutoLaravel
Laravel est un framework PHP. créé par Taylor Otwell en 2011, qui permet de simplifier le développement d'applications web tout en gardant le code bien organisé. Depuis sa création, Laravel est devenu l'un des frameworks PHP les plus populaires et les plus utilisés, avec une communauté de développeurs en constante croissance.

Laravel est basé sur le modèle MVC (Modèle-Vue-Contrôleur), qui permet de séparer le code en trois couches distinctes pour une meilleure organisation et une maintenance plus facile. Le modèle s'occupe de la logique de l'application et de l'interaction avec la base de données, la vue est responsable de l'affichage de l'interface utilisateur, et le contrôleur agit comme une passerelle entre le modèle et la vue, en traitant les requêtes entrantes et en envoyant les données à la vue.

Laravel fournit également de nombreux composants prêts à l'emploi, tels que l'authentification, la validation, la gestion des fichiers, la mise en cache, la gestion des sessions, la gestion des tâches planifiées et bien d'autres.

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




chapitre 6 le modele biding 

Le modèle binding nous permet de lier un paramètre de route à un modèle de base de données. Par exemple, supposons que nous avons une route qui prend un ID et un slug comme paramètres.

function show (string $slug, string $id) {
// On récupère l'article à partir de son ID
$post = Post::findOrFail($id);
// ...
}
Cette logique sera très souvent présente dans le code de nos controller et Laravel peut faire cela dynamiquement en liant en récupérant automatiquement la donnée à partir de la clef primaire.

Pour utiliser le modèle binding, vous devez d'abord changer le nommage de vos paramètres de route. Dans notre exemple, nous allons changer l'ID en post.

Route::get('/blog/{slug}-{post}', [PostController::class, 'show'])
Ensuite, vous devez renommer le paramètre $post dans votre controller en lui donnant un type correspondant au model que vous souhaitez utiliser.

function show (string $slug, Post $post) {
// $post sera automatiquement récupéré par Laravel
// ...
}
Si vous essayez d'accéder à un article qui n'existe pas, Laravel renverra une exception qui se traduira par une erreur 404.

Vous pouvez également choisir le champs à utiliser lors de la résolution de ce model binding dans le cas où vous ne souhaitez pas utiliser la clef primaire.

Route::get('/blog/{post:slug}', [PostController::class, 'show'])

chapitre7 
Laravel debugbar
Laravel Debugbar, comme son nom l'indique, va générer une barre qui vous permettra d'inspecter différentes choses sur le framework. Vous pourrez notamment voir quelle partie de code a pris le plus de temps, les erreurs, les différentes vues incluses par votre système, les informations concernant la route, les requêtes SQL, les modèles, etc.

L'installation se fait grâce à composer.

composer require barryvdh/laravel-debugbar --dev
Cette installation va automatiquement configurer le framework pour afficher la barre de debug lorsque la variable d'environnement APP_DEBUG sera à true.

Laravel ide helper
Du même auteur, Laravel IDE Helper permettra de générer des fichiers pour avoir une meilleur complétion au niveau de votre éditeur. L'installation se fait aussi au travers de composer.

composer require --dev barryvdh/laravel-ide-helper
Vous pourrez ensuite utiliser de nouvelles commandes artisan pour générer les fichiers d'aide.

php artisan clear-compiled
php artisan ide-helper:generate
php artisan ide-helper:models -M
php artisan ide-helper:meta
Vous pourrez trouver plus d'informations sur la documentation de l'outils pour le rôle de ces différentes commandes. La plus intéressante à mon sens est la commande ide-helper:models -M car c'est elle qui vous permettra de documenter vos models pour obtenir plus de détails sur les propriétés qu'ils contiennent.



lecon 10 les formulaires 

Dans ce chapitre nous allons attaquer la partie formulaire de Laravel et on va voir comment faire en sorte de pouvoir soumettre des informations pour créer ou modifier un article. Laravel ne fournit pas forcément d'outils pour générer le code HTML des formulaire (si on le compare à ce que propose Symfony) mais fournit différentes choses qui vont nous simplifier la tâche pour la génération des vues.

Les méthodes utiles
@csrf
Par défaut Laravel offre une protection CSRF qui permet de se protéger contre les attaques de type # Cross-site request forgery qui consiste à faire poster un formulaire depuis un site extérieur.

Aussi, si vous créer un formulaire classique vous allez obtenir une erreur lors de sa soumission et vous devrez créer un champs caché contenant une clef CSRF pour que votre formulaire fonctionner. La directive @csrf permet de faire cela automatiquement.

@error
En cas d'erreur, l'utilisateur est automatiquement redirigé vers la page précédente avec les erreurs de validations sauvegardées en session. Pour gérer l'affichage des erreurs Laravel offre la directive @error qui permet d'afficher un message en cas d'erreur ou de conditionner l'affichage d'une classe.

old()
En plus des erreurs, en cas de redirection on veut aussi pouvoir réafficher les dernières informations rentrées par l'utilisateur dans le formulaire. La méthode old() va justement permettre de récupérer ces informations depuis la session. On pourra aussi lui passer en second paramètre une valeur par défaut à appliquer si il n'y a pas de valeur provenant de la session.

old('firstname', $post->firstname);
@method
Enfin, une dernière directive vous permettra de créer un champs caché qui permettra de simuler des méthodes qui ne sont pas supportées par les formulaires HTML de base.

@method("PUT")
Exemple
Voici un petit exemple de formulaire construit avec

<form action="{{ route('post.create') }}" method="post" class="vstack gap-2">
    @csrf
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control @error("title") is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
        @error("title")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" class="form-control @error("slug") is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
        @error("slug")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="content">Contenu</label>
        <textarea id="content" class="form-control @error("content") is-invalid @enderror"  name="content">{{ old('content') }}</textarea>
        @error("content")
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button class="btn btn-primary">
        Créer
    </button>
</form>
Amélioration
La création de formulaire peut rapidement devenir très verbeux aussi il ne faudra pas hésiter à se créer des morceaux de template réutilisable pour vous rendre plus efficace.

<form action="{{ route('post.create') }}" method="post" class="vstack gap-2">
    @csrf
    @include('shared.input', ['name' => 'title', 'label' => 'Titre'])
    @include('shared.input', ['name' => 'slug', 'label' => 'URL'])
    @include('shared.input', ['name' => 'content', 'label' => 'Contenu', 'type' => 'textarea'])
    <button class="btn btn-primary">
        Créer
    </button>
</form>
