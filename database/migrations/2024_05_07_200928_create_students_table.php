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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID'); // Khóa ngoại
            $table->foreign('userID')->references('id')->on('user1s');
            $table->string('fullName');
            $table->string('gender');
            $table->date('dateOfBirth');
            $table->string('nickName');
            $table->string('placeOfBirth');
            $table->string('permanenAddress');
            $table->string('avata');
            $table->string('nationalIdentityCard');
            $table->string('ethnicity');
            $table->string('religion');
            $table->string('educationalLevel');
            $table->string('DateOffAdmissionToDTNCS');
            $table->string('policyBeneficiary');
            $table->string('contactAddress');
            $table->string('hometown');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
