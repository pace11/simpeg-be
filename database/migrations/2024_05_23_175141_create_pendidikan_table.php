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
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nomor_ijazah')->nullable();
            $table->text('nama_instansi')->nullable();
            $table->text('jurusan')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedInteger('pendidikan_terakhir_id');
            $table->timestamps();
        });

        Schema::table('pendidikan', function (Blueprint $table) {
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
            $table->foreign('pendidikan_terakhir_id')->references('id')->on('pendidikan_terakhir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
