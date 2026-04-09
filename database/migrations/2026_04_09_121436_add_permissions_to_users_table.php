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
        Schema::connection('admin')->table('users', function (Blueprint $table) {
            $table->boolean('can_manage_locations')->default(false);
            $table->boolean('can_manage_brands')->default(false);
            $table->boolean('can_manage_discounts')->default(false);
            $table->boolean('can_manage_users')->default(false);
            $table->boolean('can_manage_admins')->default(false);
            $table->boolean('is_super_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
