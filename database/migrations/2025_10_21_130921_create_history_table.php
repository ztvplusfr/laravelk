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
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('watchable'); // watchable_id et watchable_type (Movie ou Series)
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->integer('progress_seconds')->default(0); // Progression en secondes
            $table->integer('total_seconds')->nullable(); // Durée totale de la vidéo
            $table->boolean('completed')->default(false); // Si la vidéo a été regardée entièrement
            $table->timestamp('watched_at')->useCurrent(); // Quand la vidéo a été regardée
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['user_id', 'watched_at']);
            $table->index(['user_id', 'watchable_id', 'watchable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
