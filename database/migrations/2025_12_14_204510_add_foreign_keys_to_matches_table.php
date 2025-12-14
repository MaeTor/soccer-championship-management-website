<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->foreign(['team0'], 'matches_ibfk_1')->references(['id'])->on('teams')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['team1'], 'matches_ibfk_2')->references(['id'])->on('teams')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropForeign('matches_ibfk_1');
            $table->dropForeign('matches_ibfk_2');
        });
    }
};
