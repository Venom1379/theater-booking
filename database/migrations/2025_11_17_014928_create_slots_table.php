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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_id')
                  ->constrained('shows')
                  ->onDelete('cascade'); // delete slots if show deleted
            $table->string('slot_name');      // Slot name (Slot 1, Evening Slot, etc.)
            $table->time('start_time');       // Slot start time
            $table->time('end_time');         // Slot end time
            $table->decimal('price', 8, 2)->default(0); // Price for this slot
         
            $table->enum('status', ['active','cancelled','archived'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
