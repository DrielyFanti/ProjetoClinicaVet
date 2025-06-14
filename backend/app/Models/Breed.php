<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    // Disable automatic timestamps since the table doesn't have created_at/updated_at columns
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'description',
        'species_id',
        'is_active',
    ];
    
    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
