<?php

namespace App\Models;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [];

    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'category_id', 'id');
    }
}
