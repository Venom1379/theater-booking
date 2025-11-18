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
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theater_id')
                  ->constrained('theaters')
                  ->onDelete('cascade'); // delete shows if theater deleted
            $table->string('name');           // Show name (e.g., Morning Show)
            $table->string('event_name')->nullable(); // Optional movie/event title
            $table->date('show_date');        // Date of show
            $table->enum('status', ['active','cancelled','archived'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
