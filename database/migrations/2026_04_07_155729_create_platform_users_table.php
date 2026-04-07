<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('member')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('verifi_email')->unique()->nullable();
            $table->timestamp('verifi_email_verified_at')->nullable();
            $table->string('id_photo_path')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('password');
            $table->date("verifi_expiration_date")->nullable();
            $table->date("abonnement_expiration_date")->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::connection('member')->create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::connection('member')->create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::connection('member')->dropIfExists('users');
        Schema::connection('member')->dropIfExists('password_reset_tokens');
        Schema::connection('member')->dropIfExists('sessions');
    }
};