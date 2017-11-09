<?php

namespace App\Http\Controllers\Front;

use App\{
    Http\Controllers\Controller, Http\Requests\SearchRequest, Models\CryptoCurrency, Repositories\PostRepository, Models\Tag, Models\Category
};
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use App\Models\UserWallet;

class PostController extends Controller
{
    /**
     * The PostRepository instance.
     *
     * @var \App\Repositories\PostRepository
     */
    protected $postRepository;

    /**
     * The pagination number.
     *
     * @var int
     */
    protected $nbrPages;

    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\PostRepository $postRepository
     * @return void
    */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->nbrPages = config('app.nbrPages.front.posts');
    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = $this->postRepository->getActiveOrderByDate($this->nbrPages);
        $properties = Property::all();

        return view('front.index', compact('properties'));
    }

    /**
     * Display a listing of the posts for the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category)
    {
        $posts = $this->postRepository->getActiveOrderByDateForCategory($this->nbrPages, $category->slug);
        $info = __('Posts for category: ') . '<strong>' . $category->title . '</strong>';

        return view('front.index', compact('posts', 'info'));
    }

    /**
     * Display the specified post by slug.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $user = $request->user();

        return view('front.post', array_merge($this->postRepository->getPostBySlug($slug), compact('user')));
    }

    /**
     * Get posts for specified tag
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function tag(Tag $tag)
    {
        $posts = $this->postRepository->getActiveOrderByDateForTag($this->nbrPages, $tag->id);
        $info = __('Posts found with tag ') . '<strong>' . $tag->tag . '</strong>';

        return view('front.index', compact('posts', 'info'));
    }

    /**
     * Get posts with search
     *
     * @param  \App\Http\Requests\SearchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        $search = $request->search;
        $posts = $this->postRepository->search($this->nbrPages, $search)->appends(compact('search'));
        $info = __('Posts found with search: ') . '<strong>' . $search . '</strong>';

        return view('front.index', compact('posts', 'info'));
    }


    /**
     * Display a listing of community.
     *
     * @return \Illuminate\Http\Response
     */
    public function community()
    {
        return view('front.community');
    }

    /**
     * Display a listing of owners.
     *
     * @return \Illuminate\Http\Response
     */
    public function owners()
    {
        return view('front.owners');
    }

    /**
     * Display a listing of investors.
     *
     * @return \Illuminate\Http\Response
     */
    public function investors()
    {
        return view('front.investors');
    }


    /**
     * Display the welcome message.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $user = User::find(auth()->user()->id);
        return view('front.welcome', compact('user'));
    }

    /**
     * Display a listing of properties.
     *
     * @return \Illuminate\Http\Response
     */
    public function properties()
    {
        $properties = Property::all();
        return view('front.properties', compact('properties'));
    }

    /**
     * Display a property.
     *
     * @return \Illuminate\Http\Response
     */
    public function property($id)
    {
        $property = Property::find($id);
        return view('front.property', compact('properties'));
    }


    /**
     * Display a listing of crypto currencies.
     *
     * @return \Illuminate\Http\Response
     */
    public function cryptoCurrencies()
    {
        $cryptoCurrencies = CryptoCurrency::all();
        return view('front.crypto_currencies', compact('cryptoCurrencies'));
    }

    /**
     * Display the user panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function panel()
    {
        $user = User::find(auth()->user()->id);

        $standardWallets = UserWallet::whereHas('currency', function($q){
            $q->where('type', '=','currency');
        })->where('user_id', $user->id)->get();

        $tokenWallets = UserWallet::whereHas('currency', function($q){
            $q->where('type', '=','token');
        })->where('user_id', $user->id)->get();

        return view('front.panel', compact('user','standardWallets', 'tokenWallets'));
    }

}
