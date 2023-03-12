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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 100)->nullable();
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nip_lama', 15)->nullable();
            $table->string('nip_baru', 40)->nullable();
            $table->date('tmt_golongan')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->boolean('kepala_sekolah')->nullable();
            $table->enum('pendidikan_terakhir', ['SMP','SMA','SMEA','SMK','D1','D2','D3','D4','S1','S2','S3'])->nullable();
            $table->text('jurusan')->nullable();
            $table->string('tahun_lulus', 4)->nullable();
            $table->enum('pd_pdp_npd', ['PD','PDP','NPD'])->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedInteger('golongan_id');
            $table->unsignedInteger('jabatan_id');
            $table->unsignedInteger('agama_id');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });

        Schema::table('pegawai', function (Blueprint $table) {
            $table->foreign('golongan_id')->references('id')->on('golongan');
            $table->foreign('jabatan_id')->references('id')->on('jabatan');
            $table->foreign('agama_id')->references('id')->on('agama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
};
