<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code'); // e.g., CAD, USD, GBP, etc.
            $table->decimal('rate_to_usd', 10, 4); // exchange rate to USD
            $table->date('rate_date'); // date of exchange rate
            $table->timestamps();

            $table->unique(['currency_code', 'rate_date']); // prevent duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};
