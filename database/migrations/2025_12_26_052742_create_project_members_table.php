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
        Schema::create('project_members', function (Blueprint $table) {
           $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Roles: 'bidder', 'developer', 'idle'
            $table->string('role'); 
            
            // Is this the 'Main' developer? (Useful for your 45% calculation)
            $table->boolean('is_main_developer')->default(false);

            // Manually override share if needed (0-100)
            // This handles the "Bidder contribution 1% to 50%" logic
            $table->decimal('contribution_share', 5, 2)->default(0); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};
