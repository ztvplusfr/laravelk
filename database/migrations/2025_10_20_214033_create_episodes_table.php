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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')->constrained()->onDelete('cascade');
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('still_path')->nullable();
            $table->integer('episode_number');
            $table->date('air_date')->nullable();
            $table->integer('runtime')->nullable(); // en minutes
            $table->decimal('rating', 3, 1)->nullable(); // note sur 10
            $table->integer('vote_count')->default(0);
            $table->string('tmdb_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['series_id', 'season_id', 'episode_number']);
            $table->index(['air_date']);
            $table->index(['rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};