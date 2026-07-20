<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('counselor_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('scheduled_at');
            $table->enum('session_type', ['individual','group'])->default('individual');
            $table->enum('status', ['planned','done'])->default('planned');
            $table->enum('privacy_level', ['private','restricted','public'])->default('private');
            $table->timestamps();
        });

        Schema::create('counseling_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('counseling_sessions')->cascadeOnDelete();
            $table->text('note_text');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->boolean('confidential')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('counseling_notes');
        Schema::dropIfExists('counseling_sessions');
    }
};
