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
        Schema::create('tournaments_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->string('participant_type');
            $table->unsignedBigInteger('participant_id');
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();

            $table->unique(['tournament_id', 'participant_type', 'participant_id'], 'tp_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments_participants');
    }
};
