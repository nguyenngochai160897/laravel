<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains tewhe "web" middlare group. Now create something great!
|
*/

Route::group(["middleware" => "auth"], function (){
    //index
    Route::get("/", function(){
        return view("index");
    });
    //post
    Route::get("/post","PostController@index")->name("post");
    Route::get("/add-post", "PostController@create")->name("create-post");
    Route::post("/add-post", "PostController@store")->name("add-post");
    Route::get("/update-post/{id}", "PostController@edit")->name("edit-post");
    Route::post("/update-post/{id}", "PostController@update")->name("update-post");
    Route::get("/delete/{id}", "PostController@delete")->name("delete-post");
    //category
    Route::post("/add-category", "CategoryController@store")->name("add-category");
    Route::get('/category', "CategoryController@index")->name("category");
    Route::get("/update-category/{id}", "CategoryController@edit")->name("edit-category");
    Route::post("/update-category/{id}", "CategoryController@update")->name("update-category");
    Route::get("/add-category",function () {
        return view("add-category");
    });
    Route::get("/delete-category/{id}", "CategoryController@delete")->name("delete-category");
});

Auth::routes(['register' => false]);

Route::prefix('detail')->group(function () {
    Route::get('/', "DetailController@index")->name("index-detail");
    Route::get("/{id}", "DetailController@show")->name("show-detail");
});

Route::get("/job", "JobController@getCompany");