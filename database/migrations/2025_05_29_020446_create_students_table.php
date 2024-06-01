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
            $table->string('name');
            $table->string('email')->unique();
            $table->bigInteger('phone')->unique();
            $table->date('birth_date')->nullable();
            $table->integer('age')->nullable();
            $table->string('photo')->nullable();
            $table->string('gender');
            $table->string('class');
            $table->string('batch');
            $table->string('os');
            $table->string('ip')->nullable();
            $table->timestamps();

            $table->foreign('class')->references('cname')->on('courses')->onDelete('cascade');
            $table->foreign('batch')->references('bname')->on('batches')->onDelete('cascade');
            $table->foreign('os')->references('name')->on('os')->onDelete('cascade');
            $table->foreign('gender')->references('name')->on('genders')->onDelete('cascade');
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
