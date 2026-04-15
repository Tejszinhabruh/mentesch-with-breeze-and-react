<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'image'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function allergens(){
        return $this->belongsToMany(Allergen::class);
    }
}