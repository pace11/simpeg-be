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
        Schema::create('aktifitas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl_aktifitas')->nullable();
            $table->text('aktifitas')->nullable();
            $table->unsignedBigInteger('pegawai_id');
            $table->timestamps();
        });

        Schema::table('aktifitas', function (Blueprint $table) {
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
        Schema::dropIfExists('jobs');
    }
};


// $table->timestamp('period_date', $precision = 0)->nullable();