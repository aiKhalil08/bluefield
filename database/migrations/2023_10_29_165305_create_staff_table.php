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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20);
            $table->string('last_name', 30);
            $table->string('username', 20);
            $table->enum('role', ['admin', 'receptionist', 'security', 'janitor'])->nullable('unspecified');
            $table->string('password', 200)->nullable();
            $table->unique('username', 'staff_username_unique');
            $table->index('last_name', 'staff_last_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
