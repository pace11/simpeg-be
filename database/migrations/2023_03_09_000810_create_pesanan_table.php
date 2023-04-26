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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('qty')->nullable();
            $table->bigInteger('discount_price')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->enum('status', ['hold', 'waiting-payment', 'delivery', 'done'])->default('hold');
            $table->unsignedInteger('produk_id');
            $table->unsignedBigInteger('users_id');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->foreign('produk_id')->references('id')->on('produk');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};
