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
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->text('ttd_sk')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('pegawai_id');
            $table->timestamps();
        });

        Schema::table('pekerjaan', function (Blueprint $table) {
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaan');
    }
};
