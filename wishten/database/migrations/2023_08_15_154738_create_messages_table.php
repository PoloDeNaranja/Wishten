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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();//con id laravel automaticamente sabe que es la clave primaria
            $table->foreignId('id_conversation')->constrained('conversations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_sender')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('id_receiver')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('content')->nullable();
            $table->timestamp('date')->nullable();//laravel va a coger la fecha y hora en la que se ha metido en la tabla la entrada, si por
            //si por algún laravel no es capaz de actualizar automaticamente esa columna a la hora de crear la entrada se deja a null


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
