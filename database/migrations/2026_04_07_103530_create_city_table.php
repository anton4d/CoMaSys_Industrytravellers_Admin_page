<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('discounts')->create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->double('latitude')->default(0.0);
            $table->double('longitude')->default(0.0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('discounts')->dropIfExists('cities');
    }
};