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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // Auto-incrementing internal ID (1, 2, 3...)
            
            // --- YOUR NEW COLUMNS HERE ---
            $table->string('subjectID')->unique(); // e.g. "CS101"
            $table->string('subject_name');        // e.g. "Software Engineering"
            
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};