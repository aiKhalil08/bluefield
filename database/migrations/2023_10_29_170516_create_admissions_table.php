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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('session_id')->unsigned();
            $table->bigInteger('ward_id')->unsigned();
            $table->tinyInteger('bunk');
            $table->timestamp('discharge_date')->nullable();
            $table->unique('session_id', 'admissions_session_id_unique');
            $table->index('ward_id', 'admissions_ward_id_index');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('ward_id')->references('id')->on('wards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
