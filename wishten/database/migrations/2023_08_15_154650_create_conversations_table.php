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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();//con id laravel automaticamente sabe que es la clave primaria
            $table->foreignId('id_user')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_company')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_offer')->constrained('offers')->onUpdate('cascade')->onDelete('cascade');

            // $table->timestamps(); crea automaticamnte 2 columnas, una de creaated_at y una de updated_at
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
        Schema::dropIfExists('conversations');
    }
};