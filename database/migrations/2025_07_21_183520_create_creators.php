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
        Schema::create('creators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('platform'); // Facebook, Instagram, TikTok, YouTube, etc.
            $table->string('category'); // Fashion, Tech, Food, Gaming, etc.
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('followers_count')->default(0);
            $table->integer('engagement_rate')->default(0); // percentage
            $table->decimal('price_per_post', 10, 2)->default(0);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_rising_star')->default(false);
            $table->boolean('is_top_creator')->default(false);
            $table->integer('views_count')->default(0);
            $table->boolean('fast_turnaround')->default(false); // delivers quickly
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for better search performance
            $table->index(['platform', 'category']);
            $table->index('is_trending');
            $table->index('is_rising_star');
            $table->index('price_per_post');
            $table->index('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creators');
    }
};
