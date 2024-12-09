<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que califica
            $table->foreignId('psychologist_id')->constrained('users')->onDelete('cascade'); // Psicólogo calificado
            $table->integer('rating'); // Calificación
            $table->text('comment')->nullable(); // Comentario opcional
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}