<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $results = Category::latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Category', [
            'status' => session('status'),
            'results' => $results,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('status', 'Success');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name" => "required|unique:categories,name,{$category->id},id",
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('status', 'Success');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with('status', 'Success');
    }
}
