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
        Schema::create('support', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('typeOf');
            $table->string('problem');
            $table->string('status')->default('Otwarty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support');
    }
};
