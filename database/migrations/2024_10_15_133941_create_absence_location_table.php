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
        Schema::create('absence_location', function (Blueprint $table) {
            $table->id();
            $table->string('location_name', 50);
            $table->text('location_address');
            $table->string('location_latitude');
            $table->string('location_longitude');
            $table->integer('location_radius');
            $table->text('location_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absence_location');
    }
};
