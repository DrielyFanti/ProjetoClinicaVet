<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained()->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');
            $table->string('service');
            $table->dateTime('date');
            $table->text('notes')->nullable();
            $table->enum('status', ['agendada', 'realizada', 'cancelada'])->default('agendada');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}; 