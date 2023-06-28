<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use Inertia\Inertia;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        $results = Recipe::search($request)
            ->withIngredients()
            ->withCategory()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Recipe/Index', [
            'status' => session('status'),
            'results' => $results,
            'categories' => $categories,
            'ingredients' => $ingredients,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();

        return Inertia::render('Recipe/Create', [
            'status' => session('status'),
            'categories' => $categories,
            'ingredients' => $ingredients,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:recipes,name',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array',
            'ingredients.*.id' => 'required',
            'ingredients.*.amount' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $recipe = Recipe::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
            ]);

            $ingredients = collect($request->ingredients)->mapWithKeys(function ($ingredient) {
                return [$ingredient['id'] => ['amount' => $ingredient['amount']]];
            })->all();

            $recipe->ingredients()->syncWithoutDetaching($ingredients);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->route('recipe.index')->with('status', 'Success');
    }

    public function edit(Recipe $recipe)
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        $recipeIngredients = $recipe->ingredients->map(function ($data) {
            return ['id' => $data->id, 'amount' => $data->pivot->amount];
        });

        return Inertia::render('Recipe/Edit', [
            'status' => session('status'),
            'categories' => $categories,
            'ingredients' => $ingredients,
            'recipe' => $recipe,
            'recipe_ingredients' => $recipeIngredients,
        ]);
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => "required|unique:recipes,name,{$recipe->id},id",
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $recipe->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
            ]);

            $ingredients = collect($request->ingredients)->mapWithKeys(function ($ingredient) {
                return [$ingredient['id'] => ['amount' => $ingredient['amount']]];
            })->all();

            $recipe->ingredients()->syncWithoutDetaching($ingredients);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->route('recipe.index')->with('status', 'Success');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect()->back()->with('status', 'Success');
    }
}
