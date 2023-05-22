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
        Schema::create('booking_gyms', function (Blueprint $table) {
            // $table->id();
            $table->string('id_gym');
            $table->string('bulan');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('slot_waktu');
            $table->integer('sisa_kuota');
            $table->string('id_member');
            $table->string('nama');
            $table->string('status');   
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
        Schema::dropIfExists('booking_gyms');
    }
};
