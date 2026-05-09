<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $featured   = Product::where('is_available', 1)->latest()->take(8)->get();
        $popular    = Product::where('is_available', 1)->inRandomOrder()->take(4)->get();
        return view('client.home.index', compact('categories', 'featured', 'popular'));
    }

    public function menu(Request $request)
    {
        $categories = Category::all();
        $query      = Product::where('is_available', 1)->with('category');

        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12)->appends($request->query());
        return view('client.home.menu', compact('products', 'categories'));
    }

    public function product($id)
    {
        $product  = Product::with('category')->findOrFail($id);
        $related  = Product::where('category_id', $product->category_id)
                           ->where('id', '!=', $id)
                           ->take(4)->get();
        return view('client.home.product', compact('product', 'related'));
    }
}
