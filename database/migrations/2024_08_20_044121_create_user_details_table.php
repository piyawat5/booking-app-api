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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('user by id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('avatar_head')->nullable();
            $table->string('avatar_hair')->nullable();
            $table->string('avatar_face')->nullable();
            $table->string('avatar_skin')->nullable();
            $table->string('avatar_shirt')->nullable();
            $table->string('avatar_back')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
