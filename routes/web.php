<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Categories
Route::get('/categories/status/update/{category}', 'CategoryController@statusUpdate')->name('categories.status.update');
Route::resource('/categories', 'CategoryController');

Route::post('allposts', 'PostController@getAllPost')->name('allposts');
Route::resource('/posts', 'PostController');
