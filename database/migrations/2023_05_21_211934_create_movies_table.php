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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('genre');
            $table->string('director');
            $table->year('release');
            $table->integer('longTime');
            $table->float('rate');
            $table->string('img_path');
            $table->integer('pricePerDay');
            $table->string('available')->default('dostępny');
        });
        Schema::table('loans', function (Blueprint $table) {
            $table->foreignId('movie_id')->nullable()->constrained();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
