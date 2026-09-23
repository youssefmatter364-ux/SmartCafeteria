<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('favorite_categories')->nullable();
            $table->string('preferred_taste')->nullable();
            $table->string('dietary_preferences')->nullable();
            $table->decimal('max_budget', 8, 2)->nullable();
            $table->integer('spicy_level')->default(0);
            $table->text('favorite_ingredients')->nullable();
            $table->text('disliked_ingredients')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_preferences');
    }
};