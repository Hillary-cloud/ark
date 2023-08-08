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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->decimal('amount', 10, 2);
            $table->string('payment_for'); // Assuming this column exists
            $table->unsignedBigInteger('advert_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
    
            $table->foreign('advert_id')->references('id')->on('adverts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
