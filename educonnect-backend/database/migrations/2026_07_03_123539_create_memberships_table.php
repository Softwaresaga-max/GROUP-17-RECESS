<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id('membership_id');
            $table->foreignId('group_id')->constrained('groups', 'group_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('joined_at')->useCurrent();
        });
    }
    public function down(): void {
        Schema::dropIfExists('memberships');
    }
};
