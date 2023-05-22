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
        Schema::create('booking_pakets', function (Blueprint $table) {
            // $table->id();
            $table->string('id_booking_pkt');
            $table->string('id_member');
            $table->string('nama');
            $table->string('id_instruktur');
            $table->string('id_jadwal_harian');
            $table->string('nama_instruktur');
            $table->string('nama_kelas');
            $table->date('tanggal');
            $table->time('waktu');
            $table->integer('sisa_paket');
            $table->date('masa_berlaku');
            $table->date('status');
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
        Schema::dropIfExists('booking_pakets');
    }
};
