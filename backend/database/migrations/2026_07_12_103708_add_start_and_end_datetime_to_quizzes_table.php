<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {

            $table->dateTime('start_datetime')
                ->nullable()
                ->after('duration');

            $table->dateTime('end_datetime')
                ->nullable()
                ->after('start_datetime');

        });
    }


    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {

            $table->dropColumn([
                'start_datetime',
                'end_datetime'
            ]);

        });
    }
};