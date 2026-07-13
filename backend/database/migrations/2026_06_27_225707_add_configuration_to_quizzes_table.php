<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->date('quiz_date')->nullable()->after('description');
            $table->time('start_time')->nullable()->after('quiz_date');
            $table->integer('duration')->nullable()->after('start_time');
            $table->string('student_category')->nullable()->after('duration');
            $table->string('status')->default('draft')->after('student_category');
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn([
                'quiz_date',
                'start_time',
                'duration',
                'student_category',
                'status',
            ]);
        });
    }
};