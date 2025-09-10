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
        Schema::table('spcifics', function (Blueprint $table) {
            $table->integer('seat_count')->default(0)->after('code_chanal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spcifics', function (Blueprint $table) {
            $table->dropColumn('seat_count');
        });
    }
};
