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
        Schema::create('patient_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->unsigned();
            $table->integer('age')->unsigned();
            $table->integer('weight')->unsigned();
            $table->integer('height')->unsigned();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-',]);
            $table->enum('genotype', ['AA', 'AS', 'AC', 'SS', 'SC',]);
            $table->enum('marital_status', ['married', 'single',]);
            $table->unique('patient_id', 'patient_data_patient_id_unique');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_data');
    }
};
