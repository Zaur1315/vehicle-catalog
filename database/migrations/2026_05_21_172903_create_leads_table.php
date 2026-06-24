<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('vehicles')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('type')->default('contact');

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('email')->nullable();
            $table->string('phone');

            $table->string('preferred_contact_time')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();

            $table->string('status')->default('new');
            $table->string('source')->default('website');

            $table->json('payload')->nullable();

            $table->timestamps();

            $table->index('vehicle_id');
            $table->index('type');
            $table->index('status');
            $table->index('source');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
