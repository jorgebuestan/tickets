<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('ticket_selections')
            ->whereNull('twitter_username')
            ->orWhere('twitter_username', '')
            ->delete();

        $duplicates = DB::table('ticket_selections')
            ->select('twitter_username', DB::raw('MIN(id) as keep_id'))
            ->groupBy('twitter_username')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('ticket_selections')
                ->where('twitter_username', $duplicate->twitter_username)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('ticket_selections', function (Blueprint $table) {
            $table->unique('twitter_username');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_selections', function (Blueprint $table) {
            $table->dropUnique(['twitter_username']);
        });
    }
};
