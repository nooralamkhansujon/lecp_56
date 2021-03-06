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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('checkout','OrderController');

//checkout paypal 
Route::get('paypal','OrderController@paypalIndex')->name('checkout.paypalIndex');
Route::post('paypal','OrderController@paypal')->name('checkout.paypal');

Route::get('processPaypal','OrderController@processPaypal')->name('process.paypal');
Route::get('cancelPaypal','OrderController@cancelPaypal')->name('cancel.paypal');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as' =>'products.','prefix'=>'products'],function(){
     Route::get('/','ProductController@show')->name('all');
     Route::get('/{product}','ProductController@single')->name('single');
     Route::get('/addToCart/{product}','ProductController@addToCart')->name('addToCart');
});




Route::group(['as' => 'cart.','prefix'=>'cart'],function(){
    Route::get('/','ProductController@cart')->name('all');
    Route::post('/remove/{product}','ProductController@removeProduct')->name('remove');
    Route::post('/update/{product}','ProductController@updateProduct')->name('update');
});








// admin routers 
Route::group(['as'=>'admin.','middleware'=>['auth','admin'],'prefix'=>'admin'],function(){

    //category route 
    Route::get('category/{category}/remove','CategoryController@remove')->name('category.remove');
    Route::get('category/trash','CategoryController@trash')->name('category.trash');
    Route::get('category/recover/{id}','CategoryController@recoverCat')->name('category.recover');

    //product route 
    Route::get('product/{product}/remove','ProductController@remove')->name('product.remove');
    Route::get('product/trash','ProductController@trash')->name('product.trash');
    Route::get('product/recover/{id}','ProductController@recoverProduct')->name('product.recover');
     
    //profile route
    Route::get('profile/{profile}/remove','ProfileController@remove')->name('profile.remove');
    Route::get('profile/trash','ProfileController@trash')->name('profile.trash');
    Route::get('profile/recover/{id}','ProfileController@recoverProfile')->name('profile.recover');

    Route::get('profile/states/{id}','ProfileController@getStates')->name('profile.states');
    Route::get('profile/cities/{id}','ProfileController@getCities')->name('profile.cities');
    
    Route::get('/dashboard','AdminController@dashboard')->name('dashboard');
    Route::resource('product','ProductController');
    Route::resource('category','CategoryController');
    Route::resource('profile','ProfileController');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');









