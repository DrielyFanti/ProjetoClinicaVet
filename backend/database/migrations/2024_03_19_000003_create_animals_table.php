<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('species_id')->constrained()->onDelete('restrict');
            $table->foreignId('tutor_id')->constrained()->onDelete('restrict');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('color', 50)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('animals');
    }
}; 