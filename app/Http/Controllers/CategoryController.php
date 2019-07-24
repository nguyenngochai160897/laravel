<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    function getAllCategory(){
        $category = new Category;
        return $category->getAllCategory();
    }
    function getCategory($id){
        $category = new Category;
        $category->id = $id;
        return $category->getCategory();
    }
    public function index(){
        $categories = $this->getAllCategory();
        return view("category")->with("categories", $categories);
    }
    public function store(CategoryRequest $request){
        $category = new Category;
        $category->name = $request->input("name");
        $category->createCategory();
        return redirect()->route("category");
    }
    function update(CategoryRequest $request, $id){
        $category = new Category;
        $category->id = $id;
        $category->name = $request->input("name");
        $category->updateCategory();
        return redirect()->route("category");
    }
    function edit($id){
        $category = new Category;
        $category->id = $id;
        return view("update-category")->with("category", $category->getCategory());
    }
    function delete($id){
        $category = new Category;
        $category->id = $id;
        $data = $category->deleteCategory();
        $data = $category->deleteCategory();
        if($data['status'] == "failed"){
            $message = "Co mot vai bai viet lien quan den danh muc nay?Khong the xoa";
            return redirect()->route("category")->withErrors(['errors'=> $message]);
        }
        return redirect()->route("category");
    }
}
