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
        Schema::create('ip_trackings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->string('country_code');
            $table->float('latitude');
            $table->float('longitude');
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['city']);
            $table->index(['region']);
            $table->index(['country']);
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_trackings');
    }
};
