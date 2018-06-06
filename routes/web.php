<?php
Route::group(["middleware" => 'guest'], function(){
	Route::post("user/register", "User\UserRegisterController@create");
	Route::get("verify/{email}", "User\UserRegisterController@verifyindex");
	Route::post("verify", "User\UserRegisterController@verify");
	Route::get('/', "User\UserRegisterController@index");
	Route::get("/login", function(){
		return view('register.login');
	})->name("login");
	Route::post("/login", "User\UserRegisterController@login");
});

Route::group(["middleware" => "auth"], function(){
	Route::get("/home", "Home\HomeController@index");
	Route::get("/logout", "Home\AdminController@logout");
	Route::get("/people", "Home\HomeController@people");
});

Route::group(["middleware" => "auth", "prefix" => "user"], function(){
	Route::post("/changeprofilepicture", "Home\AdminController@changeprofilepicture");
	Route::get("/getUserimage/{id}", "Home\HomeController@images");
	Route::post("/followuser", "Home\FollowController@follow");
	Route::resource("/post", "Home\PostController", ['except' => ['index','create', 'edit']]);
});
