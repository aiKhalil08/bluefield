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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email', 55);
            // $table->string('email_code', 20);
            $table->string('phone_number', 15);
            $table->enum('preference', ['email', 'sms']);
            $table->bigInteger('owner_id');
            $table->string('owner_type', 25);
            $table->unique(['owner_id', 'owner_type']);
            // $table->string('phone_number_code', 15);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
