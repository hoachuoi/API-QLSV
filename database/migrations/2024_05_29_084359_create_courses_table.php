<?php

use App\Models\classroom;
use App\Models\faculty;
use App\Models\semester;
use App\Models\subject;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(faculty::class)->constrained();
            $table->foreignIdFor(classroom::class)->constrained() ;
            $table->foreignIdFor(semester::class)->constrained();
            $table->foreignIdFor(subject::class)->constrained();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
