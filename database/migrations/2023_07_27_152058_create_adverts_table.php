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
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lodge_id');
            $table->string('slug');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('school_area_id');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('agent_fee', 10, 2)->nullable();
            $table->decimal('combined_price', 10, 2);
            $table->boolean('negotiable')->default(false);
            $table->string('cover_image');
            $table->json('other_images')->nullable();
            $table->string('seller_name');
            $table->string('phone_number');
            $table->dateTime('expiration_date')->nullable();
            $table->boolean('active');
            $table->boolean('draft');
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('school_area_id')->references('id')->on('school_areas')->onDelete('cascade');
            $table->foreign('lodge_id')->references('id')->on('lodges')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
};
