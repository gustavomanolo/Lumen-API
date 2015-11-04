<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CursoEstudianteMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_estudiante', function (Blueprint $table) {
            $table->increments('id');

            //-> Foreign key
            // $table->integer('profesor_id')->unsigned();
            // $table->foreign('profesor_id')->references('id')->on('profesores');

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
        Schema::drop('curso_estudiante');
    }
}
