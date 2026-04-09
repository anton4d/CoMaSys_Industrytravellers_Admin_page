<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('discounts')->create('location_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('address');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('photo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('discounts')->dropIfExists('location_infos');
    }
};