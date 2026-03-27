<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'desc', 'replist'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'allergenlists');
    }
}