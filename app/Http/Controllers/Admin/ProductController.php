<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function add()
    {
        return view('admin.product.add');
    }
    public function insert(Request $request)
    {
        $products = new Product();
        $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = rand().'.'.$file->getClientOriginalExtension();
            $file->move('assets/uploads/products/', $filename);
            $products->image = $filename;
        $products->name = $request->input('name');
        $products->description = $request->input('description');
        $products->save();
        return redirect('products')->with('status', "Product Added Successfully");
    }
}
