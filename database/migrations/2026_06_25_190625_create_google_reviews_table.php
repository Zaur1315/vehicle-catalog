<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('google_reviews', static function (Blueprint $table): void {
            $table->id();

            $table->string('google_review_name')->nullable()->unique();

            $table->string('author_name');
            $table->string('author_url')->nullable();
            $table->string('author_photo_url')->nullable();

            $table->unsignedTinyInteger('rating');
            $table->text('text')->nullable();

            $table->string('relative_time_description')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->json('payload')->nullable();

            $table->timestamps();

            $table->index(['rating', 'is_active']);
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_reviews');
    }
};
