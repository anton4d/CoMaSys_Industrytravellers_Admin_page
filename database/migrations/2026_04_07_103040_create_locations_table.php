<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('discounts')->create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('latitude');
            $table->double('longitude');
            $table->date('expiration_date');
            $table->integer('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('discounts')->dropIfExists('locations');
    }
};