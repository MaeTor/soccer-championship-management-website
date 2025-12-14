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
        Schema::table('ranking', function (Blueprint $table) {
            $table->foreign(['team_id'], 'ranking_ibfk_1')->references(['id'])->on('teams')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ranking', function (Blueprint $table) {
            $table->dropForeign('ranking_ibfk_1');
        });
    }
};
