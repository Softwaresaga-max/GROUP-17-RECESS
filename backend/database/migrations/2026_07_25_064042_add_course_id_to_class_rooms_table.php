<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add course_id to class_rooms table
     */
    public function up(): void
    {
        Schema::table('class_rooms', function (Blueprint $table) {

            $table->foreignId('course_id')
                  ->after('id')
                  ->constrained('courses')
                  ->cascadeOnDelete();

        });
    }


    /**
     * Remove course_id from class_rooms table
     */
    public function down(): void
    {
        Schema::table('class_rooms', function (Blueprint $table) {

            $table->dropForeign(['course_id']);

            $table->dropColumn('course_id');

        });
    }
};