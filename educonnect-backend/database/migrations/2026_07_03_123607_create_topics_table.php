<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('topics', function (Blueprint $table) {
            $table->id('topic_id');
            $table->foreignId('group_id')->constrained('groups', 'group_id')->onDelete('cascade');
            $table->string('title', 200);
            $table->string('ml_category', 50)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('topics');
    }
};
