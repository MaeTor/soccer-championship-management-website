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
        Schema::create('ranking', function (Blueprint $table) {
            $table->integer('team_id')->primary();
            $table->integer('position')->unique('position');
            $table->integer('match_played_count');
            $table->integer('match_won_count');
            $table->integer('match_lost_count');
            $table->integer('draw_count');
            $table->integer('goal_for_count');
            $table->integer('goal_against_count');
            $table->integer('goal_difference');
            $table->integer('points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking');
    }
};
