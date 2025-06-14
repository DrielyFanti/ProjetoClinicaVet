<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BreedController;

Route::apiResource('animals', AnimalController::class);
Route::apiResource('species', SpeciesController::class);
Route::apiResource('tutors', TutorController::class);
Route::apiResource('appointments', AppointmentController::class);
Route::apiResource('service-types', ServiceTypeController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('breeds', BreedController::class);

