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
        Schema::create('profil', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_ic');
            $table->string('no_tel');
            $table->string('jantina');
            $table->integer('umur');
            $table->string('emel');
            $table->string('alamat');
            $table->string('dun');
            $table->string('passport_calon');
            $table->integer('resume_calon');
            $table->string('manifesto');
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
        Schema::dropIfExists('profil');
    }
};
