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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reserve_id')->comment('reserve by id');
            $table->foreign('reserve_id')->references('id')->on('reserves');
            $table->boolean('ac')->default(false);
            $table->string('temp')->nullable();
            $table->boolean('monitor')->default(false);
            $table->boolean('micro')->default(false);
            $table->boolean('add_lightblub')->default(false);
            $table->boolean('towel')->default(false);
            $table->boolean('paper')->default(false);
            $table->boolean('white_board')->default(false);
            $table->boolean('add_table')->default(false);
            $table->boolean('water')->default(false);
            $table->boolean('coffee')->default(false);
            $table->boolean('juice')->default(false);
            $table->boolean('apitize')->default(false);
            $table->boolean('perfume')->default(false);
            $table->boolean('clean_before')->default(false);
            $table->boolean('clean_after')->default(false);
            $table->boolean('security')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
