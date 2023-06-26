<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $results = Ingredient::latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Ingredient', [
            'status' => session('status'),
            'results' => $results,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Ingredient::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('status', 'Success');
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            "name" => "required|unique:categories,name,{$ingredient->id},id",
        ]);

        $ingredient->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('status', 'Success');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->back()->with('status', 'Success');
    }
}
