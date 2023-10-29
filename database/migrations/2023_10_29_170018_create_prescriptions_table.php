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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('session_id')->unsigned();
            $table->set('drugs', ['Paracetamol', 'Flagyl', 'Folic Acid', 'Diclofenac', 'Diazepam', 'Lisinopryl', 'Vitamin C']);
            $table->bigInteger('pharmacist_id')->unsigned();
            $table->unique('session_id', 'prescriptions_session_id_unique');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('pharmacist_id')->references('id')->on('pharmacists');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
