<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class DetailController extends Controller
{
    function setDefaultTemplate(){
        $post = new Post();
        $posts = $post->getAllPost([
            "limit" => 4,
            "search" => [
                "category_id" => "all",
                "state" => 1, 
            ]
        ]);
        $category = new Category();
        $categories = $category->getAllCategory();
        return [
            "posts" => $posts,
            "categories" => $categories,
        ];
    }
    function index(){
        $data = $this->setDefaultTemplate();
        return view("detail.index")->with($data);
    }
    function show($id){
        $post = new Post();
        $post->id = $id;
        $data = $this->setDefaultTemplate();
        $data['post'] = $post->getPost();
        return view("detail.show-detail")->with($data);
    }
}
