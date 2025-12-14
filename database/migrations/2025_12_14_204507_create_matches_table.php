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
        Schema::create('matches', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('team0');
            $table->integer('team1')->index('team1');
            $table->integer('score0');
            $table->integer('score1');
            $table->dateTime('date')->nullable();

            $table->unique(['team0', 'team1'], 'team0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
