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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\course::class)->constrained();
            $table->foreignIdFor(\App\Models\student::class)->constrained();
            $table->date('date');
            $table->string('day_of_week');
            $table->tinyInteger('status')->comment('0: vắng mặt, 1: có mặt, 2: xin phép nghỉ');
            $table->timestamps();
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->string('week')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
