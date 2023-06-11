<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $procedure = "
        CREATE PROCEDURE calculateThePrice(IN movieId INT, IN startDate DATE, IN endDate DATE, OUT cost DECIMAL(10, 2))
        BEGIN
            DECLARE rentalDays INT;

            SELECT DATEDIFF(endDate, startDate) + 1 INTO rentalDays;

            SELECT pricePerDay INTO cost FROM movies WHERE id = movieId;

            SET cost = cost * rentalDays;
        END";

        DB::unprepared("DROP PROCEDURE IF EXISTS calculateThePrice");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $procedure = "DROP PROCEDURE IF EXISTS calculateThePrice";

        DB::unprepared($procedure);
    }
};
