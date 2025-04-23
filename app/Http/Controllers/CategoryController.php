<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{


    function index(Request $request){
        $category_key = $request->category_key;
        $categories = Category::where('category_name', 'LIKE', '%'.$category_key.'%')->orderBy('id', 'desc')->paginate(10);
        return view('category.category', compact('categories', 'category_key'));
    }

    function add(){
        return view('category.category-add');
    }

    function create(Request $request){
        $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);

        Category::create($request->all());

        Session::flash('message', 'New Category Succesfully Added!');

        return redirect()->route('category');
    }

    function show($id){

        $category = Category::with('items')->findOrFail($id);
        return view('category.category-detail', compact('category'));
    }

    function edit($id){
        $category = Category::findOrFail($id);
        return view('category.category-edit', compact('category'));
    }

    function update(Request $request, $id){

        $request->validate([
            'category_name' => 'required|unique:categories,category_name,'.$id.'|max:255', 
        ]);
        
        $category = Category::findOrFail($id);
        $category->update($request->all());

        Session::flash('message', 'Category Succesfully Updated!');
        return redirect()->route('category');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        return view('category.category-delete', compact('category'));
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        Session::flash('message', 'Category Succesfully Deleted!');
        return redirect()->route('category');
    }

    
}