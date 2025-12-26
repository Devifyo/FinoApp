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
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            
            // The month this earning belongs to (e.g., "2024-01-01")
            $table->date('earning_date'); 
            
            // Total received from Upwork (e.g., $1000)
            $table->decimal('total_amount', 15, 2);
            
            // Calculated Backup Amount (e.g., $100) - Stored for historical accuracy
            $table->decimal('backup_amount', 15, 2);
            
            // The remaining amount distributed to members (e.g., $900)
            $table->decimal('distributable_amount', 15, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earnings');
    }
};
