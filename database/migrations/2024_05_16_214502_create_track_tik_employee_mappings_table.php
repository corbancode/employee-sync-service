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
        Schema::create('track_tik_employee_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('tracktik_id');
            $table->timestamps();

            $table->unique(['provider', 'first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_tik_employee_mappings');
    }
};
