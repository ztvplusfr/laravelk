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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('backdrop_path')->nullable();
            $table->date('first_air_date')->nullable();
            $table->date('last_air_date')->nullable();
            $table->integer('number_of_seasons')->default(0);
            $table->integer('number_of_episodes')->default(0);
            $table->decimal('rating', 3, 1)->nullable(); // note sur 10
            $table->integer('vote_count')->default(0);
            $table->string('status')->default('returning'); // returning, ended, cancelled, pilot
            $table->string('original_language', 5)->nullable();
            $table->string('original_title')->nullable();
            $table->json('genres')->nullable(); // genres en JSON
            $table->json('production_companies')->nullable();
            $table->json('production_countries')->nullable();
            $table->json('networks')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('tmdb_id')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['status', 'is_active']);
            $table->index(['first_air_date']);
            $table->index(['rating']);
            $table->index(['is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};