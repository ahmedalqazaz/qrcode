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
        Schema::create('spcifics', function (Blueprint $table) {
            $table->id();
            $table->integer('code_spcific')->unique();  // Unique code for the specific item
            $table->string('name_spcific')->unique();  // Unique name for the specific item
            $table->unsignedBigInteger('code_degree');  // Foreign key to the agency table
            $table->foreign('code_degree')->references('code_degree')->on('degree')->onDelete('cascade');  // Establishing foreign key relationship with agency table
            $table->unsignedBigInteger('code_chanal');  // Foreign key to the agency table
            $table->foreign('code_chanal')->references('code_chanal')->on('chanal')->onDelete('cascade');  // Establishing foreign key relationship with agency table

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spcifics');
    }
};
