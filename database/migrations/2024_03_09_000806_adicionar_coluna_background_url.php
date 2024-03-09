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
        Schema::table('users', function (Blueprint $table) {
            $table->string('background_url')->default('https://rukminim2.flixcart.com/image/850/1000/kngd0nk0/poster/t/6/h/medium-teneur-poster-kanye-west-graduation-wallpapers-poster-12-original-imag24hzhguzeugh.jpeg?q=20&crop=false');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['background_url']);
        });
    }
};
