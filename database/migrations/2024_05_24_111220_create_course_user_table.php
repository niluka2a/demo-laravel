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
        Schema::create('course_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::statement('CREATE UNIQUE INDEX course_id_user_id_unique ON course_user (course_id, user_id, (IF(deleted_at, NULL, 1)))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE course_user DROP INDEX course_id_user_id_unique');

        Schema::create('course_user', function (Blueprint $table) {
            $table->dropForeign('course_id');
            $table->dropForeign('user_id');
        });

        Schema::dropIfExists('course_user');
    }
};
