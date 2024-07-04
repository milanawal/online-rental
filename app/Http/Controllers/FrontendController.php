<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class FrontendController extends Controller
{
    function allProducts() {
        $categories = Category::with('products')->get();
        return view('products', compact('categories'));
    }
}
