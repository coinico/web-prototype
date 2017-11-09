<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------|
*/

//Logout
Route::name('logout')->get('/logout' , 'Auth\LoginController@logout');

// Home
Route::name('home')->get('/', 'Front\PostController@index');

// Exchange
Route::name('exchange')->get('/exchange', 'Front\PostController@exchange');

//Owners
Route::name('owners')->get('/owners', 'Front\PostController@owners');

//Investors
Route::name('investors')->get('/investors', 'Front\PostController@investors');



//Community
Route::name('community')->get('/community', 'Front\PostController@community');

//Properties
Route::name('properties')->get('/properties', 'Front\PostController@properties');
Route::name('properties.display')->get('/properties/{id}', 'Front\PostController@property');

// Contact
Route::resource('contacts', 'Front\ContactController', ['only' => ['create', 'store']]);

// Posts and comments
Route::prefix('posts')->namespace('Front')->group(function () {
    Route::name('posts.display')->get('{slug}', 'PostController@show');
    Route::name('posts.tag')->get('tag/{tag}', 'PostController@tag');
    Route::name('posts.search')->get('', 'PostController@search');
    Route::name('posts.comments.store')->post('{post}/comments', 'CommentController@store');
    Route::name('posts.comments.comments.store')->post('{post}/comments/{comment}/comments', 'CommentController@store');
    Route::name('posts.comments')->get('{post}/comments/{page}', 'CommentController@comments');
});

Route::resource('comments', 'Front\CommentController', [
    'only' => ['update', 'destroy'],
    'names' => ['destroy' => 'front.comments.destroy']
]);

Route::name('category')->get('category/{category}', 'Front\PostController@category');

// Authentification
Auth::routes();


/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------|
*/

//Exchange
Route::name('ctfMarkets')->get('/ctfMarkets', 'Front\OrderBookController@ctfMarkets');



Route::middleware('community')->group(function () {

    // PropertyVote
    Route::post('/property/{id}/vote', 'Back\PropertyVoteController@vote');

});


Route::prefix('admin')->namespace('Back')->group(function () {

    Route::middleware('redac')->group(function () {

        Route::name('admin')->get('/', 'AdminController@index');

        // Posts
        Route::name('posts.seen')->put('posts/seen/{post}', 'PostController@updateSeen')->middleware('can:manage,post');
        Route::name('posts.active')->put('posts/active/{post}/{status?}', 'PostController@updateActive')->middleware('can:manage,post');
        Route::resource('posts', 'PostController');

        // Properties
        Route::name('properties.seen')->put('properties/seen/{property}', 'PropertyController@updateSeen')->middleware('can:manage,property');
        Route::name('properties.active')->put('properties/active/{property}/{status?}', 'PropertyController@updateActive')->middleware('can:manage,property');
        Route::resource('properties', 'PropertyController');

        // Notifications
        Route::name('notifications.index')->get('notifications/{user}', 'NotificationController@index');
        Route::name('notifications.update')->put('notifications/{notification}', 'NotificationController@update');


        // Medias
        Route::view('medias', 'back.medias')->name('medias.index');

    });

    Route::middleware('admin')->group(function () {

        // PropertyImages
        Route::get('/property/{id}/images', 'PropertyImageController@index');
        Route::post('/property/{id}/images', 'PropertyImageController@upload');


        // Users
        Route::name('users.seen')->put('users/seen/{user}', 'UserController@updateSeen');
        Route::name('users.valid')->put('users/valid/{user}', 'UserController@updateValid');
        Route::resource('users', 'UserController', ['only' => [
            'index', 'edit', 'update', 'destroy'
        ]]);

        // Categories
        Route::resource('categories', 'CategoryController', ['except' => 'show']);

        // Contacts
        Route::name('contacts.seen')->put('contacts/seen/{contact}', 'ContactController@updateSeen');
        Route::resource('contacts', 'ContactController', ['only' => [
            'index', 'destroy'
        ]]);

        // Comments
        Route::name('comments.seen')->put('comments/seen/{comment}', 'CommentController@updateSeen');
        Route::resource('comments', 'CommentController', ['only' => [
            'index', 'destroy'
        ]]);

        // Settings
        Route::name('settings.edit')->get('settings', 'AdminController@settingsEdit');
        Route::name('settings.update')->put('settings', 'AdminController@settingsUpdate');

    });

});

//crypto_currency Routes
Route::group(['middleware'=> 'web'],function(){

    //Welcome
    Route::name('welcome')->get('/welcome', 'Front\PostController@welcome');

    //Panel
    Route::name('panel')->get('/panel', 'Front\PostController@panel');


    Route::resource('cryptoCurrency', '\App\Http\Controllers\Front\CryptoCurrencyController');
    Route::post('cryptoCurrency/{id}/update','\App\Http\Controllers\Front\CryptoCurrencyController@update');
    Route::get('cryptoCurrency/{id}/delete','\App\Http\Controllers\Front\CryptoCurrencyController@destroy');

    // wallets
    Route::resource('wallets', 'Front\UserWalletController');
    Route::get('/userWallet/{id}/manage', 'Front\UserWalletController@manageWallet');
});