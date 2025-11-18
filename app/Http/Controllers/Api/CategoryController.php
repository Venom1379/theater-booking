<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }
    public function getSubcategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get(); 
        return response()->json($subcategories);
    }
}

