<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('student_number')->unique();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('phone')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->text('address')->nullable();
        $table->enum('status', ['active', 'inactive', 'graduated', 'suspended'])->default('active');
        $table->timestamps();
    });
}
};
