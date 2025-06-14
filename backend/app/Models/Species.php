<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    //  
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];
    
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function breeds()
    {
        return $this->hasMany(Breed::class);
    }
}
