<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 45);
            $table->string('gambar', 225)->nullable();
            $table->string('nama_brg', 45);
            $table->integer('harga');
            $table->integer('stok');
            $table->text('deskripsi');
            $table->string('penulis', 45);
            $table->string('penerbit', 45);
            $table->date('tanggal');
            $table->string('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
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
        Schema::dropIfExists('barang_models');
    }
}
