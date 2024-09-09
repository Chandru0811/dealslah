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
        Schema::table('shops', function (Blueprint $table) {
            Schema::table('shops', function (Blueprint $table) {
                $table->text('address')->nullable()->after('external_url'); 
                $table->string('ph_number');
                $table->string('email_id');
                $table->string('shop_ratings');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop', function (Blueprint $table) {
            //
        });
    }
};
