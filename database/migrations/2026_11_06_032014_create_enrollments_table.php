<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('enrollments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->foreignId('course_id')->constrained()->onDelete('cascade');
        $table->enum('status', ['enrolled', 'completed', 'dropped', 'failed'])->default('enrolled');
        $table->decimal('grade', 5, 2)->nullable(); // e.g. 1.25, 2.00, 3.00
        $table->date('enrolled_at')->nullable();
        $table->timestamps();

        $table->unique(['student_id', 'course_id']); // prevent duplicate enrollment
    });
}
};
