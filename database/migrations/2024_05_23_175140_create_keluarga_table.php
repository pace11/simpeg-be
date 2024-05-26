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
        Schema::create('keluarga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nik')->nullable();
            $table->text('nama_lengkap')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_perkawinan')->nullable();
            $table->enum('golongan_darah', ['AB', 'A', 'B', 'O'])->nullable();
            $table->enum('kewarganegaraan', ['WNI', 'WNA'])->nullable();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedInteger('agama_id');
            $table->unsignedInteger('pendidikan_kk_id');
            $table->unsignedInteger('status_perkawinan_kk_id');
            $table->unsignedInteger('status_hubungan_kk_id');
            $table->unsignedInteger('jenis_pekerjaan_kk_id');
            $table->timestamps();
        });

        Schema::table('keluarga', function (Blueprint $table) {
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
            $table->foreign('agama_id')->references('id')->on('agama');
            $table->foreign('pendidikan_kk_id')->references('id')->on('pendidikan_kk');
            $table->foreign('status_perkawinan_kk_id')->references('id')->on('status_perkawinan_kk');
            $table->foreign('status_hubungan_kk_id')->references('id')->on('status_hubungan_kk');
            $table->foreign('jenis_pekerjaan_kk_id')->references('id')->on('jenis_pekerjaan_kk');
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
