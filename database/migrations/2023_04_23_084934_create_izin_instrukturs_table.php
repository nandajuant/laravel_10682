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
        Schema::create('izin_instrukturs', function (Blueprint $table) {
            $table->id();
            $table->string('id_izin');
            $table->string('id_instruktur');
            $table->string('id_jadwal_harian');
            $table->string('nama');
            $table->date('tanggal');
            $table->string('status');
            $table->string('keterangan');
            $table->sting('id_pegawai');
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
        Schema::dropIfExists('izin_instrukturs');
    }
};
