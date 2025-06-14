<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'tutor_id',
        'service',
        'date',
        'notes',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            Log::info('Criando nova consulta:', $appointment->toArray());
        });

        static::created(function ($appointment) {
            Log::info('Consulta criada com sucesso:', $appointment->toArray());
        });
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
} 