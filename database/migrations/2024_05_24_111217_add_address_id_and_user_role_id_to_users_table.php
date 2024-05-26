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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedInteger('role_id');
            $table->softDeletes();

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropForeign('address_id');
            $table->dropForeign('role_id');

            $table->dropColumn('address_id');
            $table->dropColumn('role_id');
            $table->dropSoftDeletes();
        });
    }
};
