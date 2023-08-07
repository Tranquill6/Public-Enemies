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
        Schema::create('characters', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('rank')->default('Citizen');
            $table->integer('status')->default(0);
            $table->dateTime('diedAt')->default(null);
            $table->dateTime('jailExpiresAt')->default(null);
            $table->integer('exp')->default(0);
            $table->integer('attack')->default(0);
            $table->integer('attackMultiplier')->default(1);
            $table->integer('defense')->default(0);
            $table->integer('defenseMultiplier')->default(1);
            $table->integer('intellect')->default(0);
            $table->integer('intellectMultiplier')->default(1);
            $table->integer('stealth')->default(0);
            $table->integer('stealthMultiplier')->default(1);
            $table->integer('endurance')->default(0);
            $table->integer('enduranceMultiplier')->default(1);
        });

        Schema::create('users_characters', function(Blueprint $table) {
            $table->integer('user_id');
            $table->integer('character_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
        Schema::dropIfExists('users_characters');
    }
};
