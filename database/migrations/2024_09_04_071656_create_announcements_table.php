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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->text('message');
            $table->string('type', 50)->default('info'); 
            $table->string('image_url')->nullable();
            $table->timestamp('start_date')->nullable(); // Start date for the announcement to be visible
            $table->timestamp('end_date')->nullable(); // End date for the announcement to be hidden
            $table->boolean('active')->default(1); // Status of the announcement (active/inactive)
            $table->boolean('is_global')->default(0); // If true, the announcement is visible to all users
            $table->unsignedBigInteger('shop_id')->nullable(); 
            $table->softDeletes(); // 
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
