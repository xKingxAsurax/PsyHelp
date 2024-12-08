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
            $table->foreignId('patient_id')->constrained('users');
            $table->foreignId('psychologist_id')->constrained('users');
            $table->date('date');
            $table->time('time');
            $table->integer('duration');
            $table->enum('type', ['primera_vez', 'seguimiento', 'emergencia']);
            $table->enum('status', ['programada', 'completada', 'cancelada'])->default('programada');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};