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
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id')->comment('');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->unsignedBigInteger('reserver')->comment('');
            $table->foreign('reserver')->references('id')->on('users');
            $table->string('title');
            $table->string('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('prepare')->nullable();
            $table->string('status')->nullable();
            $table->string('users_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
