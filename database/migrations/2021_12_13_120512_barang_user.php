<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BarangUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_user', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('barang_id');
            $table->string('user_id');
            $table->string('kode_transaksi', 45)->nullable();
            $table->string('status', 45)->nullable();
            $table->string('bukti_bayar', 225)->nullable();
            $table->integer('total_bayar')->nullable();
            $table->integer('qty')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->foreign('barang_id')
                ->references('id')->on('barangs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
