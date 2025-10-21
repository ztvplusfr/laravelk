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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('episode_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('embed_url'); // URL du lien embed
            $table->string('quality')->default('HD'); // HD, FHD, 4K, etc.
            $table->string('language', 5)->default('fr'); // langue de la vidéo
            $table->json('subtitles')->nullable(); // sous-titres disponibles (tableau de langues)
            $table->boolean('is_ready')->default(false); // vidéo prête à être diffusée
            $table->boolean('is_processing')->default(false); // vidéo en cours de traitement
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['quality']);
            $table->index(['language']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};