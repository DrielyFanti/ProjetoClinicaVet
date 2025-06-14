<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tutor extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'phone',   
        'whatsapp',
        'address',
        'city',
        'state',
        'zip_code',
        'is_active',
    ];
    
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
