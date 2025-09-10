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
        Schema::create('chanels', function (Blueprint $table) {
            $table->id();
            $table->string('name_chanel')->unique();  // Unique name for the channel
            $table->unsignedBigInteger('code_chanal');  // Foreign key to the rank table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chanel');
    }
};
