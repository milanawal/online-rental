<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class FrontendController extends Controller
{
    function allProducts() {
        if(auth()->user()){
            $userId = auth()->user()->id;
            $categories = Category::with('products')->whereHas('products', function ($query) use ($userId) {
                $query->where('owner_id', '!=', $userId);
            })->get();
        }else{
            $categories = Category::with('products')->get();
        }
        return view('products', compact('categories'));
    }
}
