<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('image')->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::with('image')->findOrFail($id);
        return view('category.edit', compact('category'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        filedelete($category->image->image);
        $category->image()->delete();
        $category->delete();

        return to_route('category.index')->with('message', 'Category deleted successfully');
    }
}
