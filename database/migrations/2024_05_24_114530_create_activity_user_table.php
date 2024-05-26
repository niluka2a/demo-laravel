<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('score', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::statement('CREATE UNIQUE INDEX unique_activity_id_user_id ON activity_user (activity_id, user_id, (IF(deleted_at, NULL, 1)))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE activity_user DROP INDEX unique_activity_id_user_id');

        Schema::create('activity_user', function (Blueprint $table) {
            $table->dropForeign('subject_id');
            $table->dropForeign('user_id');
        });

        Schema::dropIfExists('activity_user');
    }
};
