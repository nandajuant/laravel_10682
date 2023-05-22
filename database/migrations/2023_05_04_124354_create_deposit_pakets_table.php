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
        Schema::create('deposit_pakets', function (Blueprint $table) {
            $table->id();
            $table->string('id_deposit_reg');
            $table->string('id_promo');
            $table->string('id_member');
            $table->string('nama');
            $table->date('tanggal');
            $table->time('waktu');
            $table->integer('deposit');
            $table->integer('biaya');
            $table->integer('bonus');
            $table->string('jenis_kelas');
            $table->integer('total_deposit');
            $table->date('masa_berlaku');
            $table->string('id_pegawai');
            $table->string('nama_pegawai');
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
        Schema::dropIfExists('deposit_pakets');
    }
};
