<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot(['amount']);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeWithIngredients($query)
    {
        return $query->with('ingredients');
    }

    public function scopeWithCategory($query)
    {
        return $query->with('category');
    }

    public function scopeSearch($query, $request)
    {
        return $query
            ->when($request->name, function ($q) use ($request) {
                $name = strtolower($request->name);
                $q->whereRaw("LOWER(name) LIKE '%{$name}%'");
            })
            ->when($request->categories, function ($q) use ($request) {
                $q->whereHas('category', function ($q) use ($request) {
                    $q->whereIn('id', $request->categories);
                });
            })
            ->when($request->ingredients, function ($q) use ($request) {
                $q->whereHas('ingredients', function ($q) use ($request) {
                    $q->whereIn('id', $request->ingredients);
                });
            });
    }
}
