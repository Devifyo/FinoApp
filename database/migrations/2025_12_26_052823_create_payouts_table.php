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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('earning_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Who got paid
            
            // Role snapshot at time of payment (e.g., "Bidder")
            $table->string('role_at_time'); 
            
            // The exact dollar amount they received
            $table->decimal('amount', 15, 2);
            
            // The percentage they got of the Distributable Amount
            $table->decimal('percentage_applied', 5, 2); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
