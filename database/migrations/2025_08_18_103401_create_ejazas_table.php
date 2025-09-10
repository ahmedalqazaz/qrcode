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
        Schema::create('ejazas', function (Blueprint $table) {
            $table->id();
            $table->string('name_ejaza')->unique();  // Unique name for the channel
            $table->unsignedBigInteger('code_ejaza');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejazas');
    }
};
