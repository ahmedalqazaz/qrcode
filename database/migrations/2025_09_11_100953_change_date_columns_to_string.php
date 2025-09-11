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
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('birth_date')->nullable()->change();
            $table->string('graduation_date')->nullable()->change();
            $table->string('admin_order_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->change();
            $table->date('graduation_date')->nullable()->change();
            $table->date('admin_order_date')->nullable()->change();
        });
    }
};
