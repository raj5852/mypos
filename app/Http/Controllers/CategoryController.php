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
        if (!rolecheck(['category'])) {
            return abort(404);
        }
        $categories = Category::with('image')
            ->withCount('products')
            ->get();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!rolecheck(['category'])) {
            return abort(404);
        }
        return view('category.create');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!rolecheck(['category'])) {
            return abort(404);
        }
        $category = Category::with('image')->findOrFail($id);
        return view('category.edit', compact('category'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $productExists = $category->products()->exists();
        if($productExists){
            return back()->with('error', 'You can not delete');
        }
        filedelete($category->image->image);
        $category->image()->delete();
        $category->delete();

        return to_route('category.index')->with('message', 'Category deleted successfully');
    }
}
