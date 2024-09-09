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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 100)->unique(); 
            $table->string('slug', 100)->unique(); 
            $table->text('description')->nullable(); 
            $table->decimal('price', 10, 2); 
            $table->integer('duration')->unsigned(); 
            $table->boolean('is_active')->default(1); 
            $table->integer('deal_limit')->unsigned()->nullable(); 
            $table->string('features')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
