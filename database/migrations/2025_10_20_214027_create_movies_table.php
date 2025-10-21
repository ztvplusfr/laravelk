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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('runtime')->nullable(); // en minutes
            $table->decimal('rating', 3, 1)->nullable(); // note sur 10
            $table->integer('vote_count')->default(0);
            $table->string('status')->default('released'); // released, upcoming, cancelled
            $table->string('original_language', 5)->nullable();
            $table->string('original_title')->nullable();
            $table->json('genres')->nullable(); // genres en JSON
            $table->json('production_companies')->nullable();
            $table->json('production_countries')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['status', 'is_active']);
            $table->index(['release_date']);
            $table->index(['rating']);
            $table->index(['is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};