<?php



Route::get('/', 'FrontEndController@index');
Route::get('/posts/details/{post}', 'FrontEndController@getSinglePost')->name('get.single.posts');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Categories
Route::get('/categories/status/update/{category}', 'CategoryController@statusUpdate')->name('categories.status.update');
Route::get('/categories/trash', 'CategoryController@getCategoryTrash')->name('categories.trash');
Route::delete('/categories/trash/{id}', 'CategoryController@restoreCategory')->name('categories.restore');
Route::resource('/categories', 'CategoryController');

// Post
Route::post('allposts', 'PostController@getAllPost')->name('allposts');
Route::get('/posts/status/update/{post}', 'PostController@statusUpdate')->name('posts.status.update');
Route::resource('/posts', 'PostController');

// Forum
Route::resource('/forums', 'ForumController');

// Comment
//Route::resource('/comments', 'CommentController');
Route::post('/comments/post/{post}', 'CommentController@postCommentStore')->name('posts.comments.store');
//Route::post('/comments/forum/{forum}', 'CommentController@forumCommentStore')->name('forums.comments.store');


