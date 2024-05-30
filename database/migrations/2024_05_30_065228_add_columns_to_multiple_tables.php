<?php

use App\Models\faculty;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id')->nullable(); // Thêm cột không có ràng buộc khóa ngoại
            $table->string('hometown')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('teacherID')->nullable();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('studentID')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable(); // Thêm cột không có ràng buộc khóa ngoại
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['faculty_id', 'hometown', 'date_of_birth', 'gender', 'teacherID']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['studentID', 'faculty_id']);
        });
    }
};
