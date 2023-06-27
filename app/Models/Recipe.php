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
        return $query;
    }
}
