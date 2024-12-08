<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('notifications_enabled')->default(true);
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(true);
            $table->string('language')->default('es');
            $table->string('timezone')->default('America/Bogota');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}; 