<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'discounts';

    public function up(): void
    {
        Schema::connection('discounts')->create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->float('latitude');
            $table->float('longitude');
            $table->tinyInteger('type')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('discounts')->dropIfExists('locations');
    }
};