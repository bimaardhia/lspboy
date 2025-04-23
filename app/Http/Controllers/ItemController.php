<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{


    function index(Request $request){
        $item_key = $request->item_key;
        $items = Item::where('item_name', 'LIKE', '%'.$item_key.'%')->orderBy('id', 'desc')->paginate(10);
        return view('item.item', compact('items', 'item_key'));
    }

    function add()
    {
        $categories = Category::all();
        return view('item.item-add', compact('categories'));
    }

    function create(Request $request){
    $request->validate([
        'item_name' => 'required|unique:items|max:255',
        'stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        ]);

        Item::create($request->all());

        Session::flash('message', 'New Item Successfully Added!');

        return redirect()->route('item');
    }

    function edit($id){
        $categories = Category::all();
        $item = Item::findOrFail($id);
        return view('item.item-edit', compact('item', 'categories'));
    }

    function update(Request $request, $id){

        $request->validate([
        'item_name' => 'required|unique:items,item_name,'.$id.'|max:255',
        'stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        ]);

        $item = Item::findOrFail($id);
        $item->update($request->all());

        Session::flash('message', 'New Item Successfully Updated!');

        return redirect()->route('item');
    }

    public function delete($id) {
        $item = Item::findOrFail($id);
        return view('item.item-delete', compact('item'));
    }

    public function destroy($id) {
        Item::findOrFail($id)->delete();
        Session::flash('message', 'Category Succesfully Deleted!');
        return redirect()->route('item');
    }

}