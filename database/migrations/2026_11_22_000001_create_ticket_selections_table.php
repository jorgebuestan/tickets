<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_selections', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('ticket_number')->unique();
            $table->string('name', 120);
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('ip_location')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_selections');
    }
};
