<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'discounts';

    public function up(): void
    {
        Schema::connection('discounts')->create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('expiration_date')->nullable();
            $table->tinyInteger('user_type')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('discounts')->dropIfExists('discounts');
    }
};