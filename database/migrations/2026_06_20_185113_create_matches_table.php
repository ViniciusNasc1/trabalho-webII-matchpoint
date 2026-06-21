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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->integer('round_number');
            $table->string('round_label');
            $table->string('participant_a_type');
            $table->unsignedBigInteger('participant_a_id');
            $table->string('participant_b_type')->nullable();
            $table->unsignedBigInteger('participant_b_id')->nullable();
            $table->string('winner_type')->nullable();
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->enum('status', ['pending', 'ongoing', 'finished'])->default('pending');
            $table->softDeletes();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
