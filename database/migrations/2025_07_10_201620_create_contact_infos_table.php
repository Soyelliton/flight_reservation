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
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->enum('type', ['phone', 'fax', 'email']);
            $table->string('value')->nullable(); // For email addresses
            $table->string('country_code')->nullable(); // for phone/fax
            $table->string('area_code')->nullable(); // for phone/fax
            $table->string('local_number')->nullable(); // for phone/fax
            $table->timestamps();
            
            // Make email addresses unique across all customers
            $table->unique(['type', 'value'], 'unique_email_per_customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};
