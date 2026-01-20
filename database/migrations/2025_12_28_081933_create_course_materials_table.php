<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_course_materials_table.php
// database/migrations/xxxx_create_course_materials_table.php

public function up(): void
{
    Schema::create('course_materials', function (Blueprint $table) {
        $table->id();
        $table->string('subject_code');
        $table->string('week_title');
        $table->string('title');
        $table->string('type')->default('file');
        $table->text('description')->nullable();
        
        // NEW: Stores the location of the uploaded file
        $table->string('file_path')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_materials');
    }
};
