<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('subject_id')->default(1)->constrained('subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->string('description');
            $table->string('video_path');
            $table->string('thumb_path');
            $table->enum('status', ['valid', 'pending', 'blocked'])->default('valid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
