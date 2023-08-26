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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();//con id laravel automaticamente sabe que es la clave primaria
            $table->foreignId('owner_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');/**Si se borra el owner_id se elimina todas las relaciones existentes en dicha tabla que tenia*/
            $table->string('title');
            $table->double('salary');
            $table->string('description');
            $table->integer('vacants');
            $table->string('document_path');
            $table->timestamps(); //crea automaticamnte 2 columnas, una de created_at y una de updated_at
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};