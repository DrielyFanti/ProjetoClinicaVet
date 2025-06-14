<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species_id',
        'tutor_id',
        'birth_date',
        'gender',
        'weight',
        'color',
        'notes',
        'is_active',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}
