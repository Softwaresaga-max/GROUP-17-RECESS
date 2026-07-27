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
        Schema::table('quizzes', function (Blueprint $table) {

            if (!Schema::hasColumn('quizzes', 'course_id')) {
                $table->foreignId('course_id')
                    ->nullable()
                    ->constrained()
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('quizzes', 'class_room_id')) {
                $table->foreignId('class_room_id')
                    ->nullable()
                    ->constrained('class_rooms')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('quizzes', 'status')) {
                $table->string('status')->default('draft');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {

            if (Schema::hasColumn('quizzes', 'class_room_id')) {
                $table->dropForeign(['class_room_id']);
                $table->dropColumn('class_room_id');
            }

            if (Schema::hasColumn('quizzes', 'course_id')) {
                $table->dropForeign(['course_id']);
                $table->dropColumn('course_id');
            }

            if (Schema::hasColumn('quizzes', 'status')) {
                $table->dropColumn('status');
            }

        });
    }
};