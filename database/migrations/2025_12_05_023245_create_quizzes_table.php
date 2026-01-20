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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('time_limit')->nullable(); // minutes
            $table->integer('pass_mark')->default(50); // percentage
            $table->integer('attempts_allowed')->default(1); // max attempts
            $table->timestamp('start_time')->nullable(); // quiz available start time
            $table->timestamp('end_time')->nullable();   // quiz available end time
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
