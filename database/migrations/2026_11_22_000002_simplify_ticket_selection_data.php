<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_selections', function (Blueprint $table) {
            $table->string('twitter_username', 80)->after('ticket_number');
            $table->dropColumn(['name', 'email', 'phone']);
        });
    }

    public function down(): void
    {
        Schema::table('ticket_selections', function (Blueprint $table) {
            $table->string('name', 120)->after('ticket_number');
            $table->string('email')->after('name');
            $table->string('phone', 30)->nullable()->after('email');
            $table->dropColumn('twitter_username');
        });
    }
};
