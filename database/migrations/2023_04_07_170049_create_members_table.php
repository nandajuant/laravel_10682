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
        Schema::create('members', function (Blueprint $table) {
            // $table->id();
            $table->string('id_member');
            $table->string('nama');
            $table->string('no_hp');
            $table->string('email');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->integer('jmml_dep_kelas');
            $table->float('jml_dep_uang');
            $table->string('password');
            $table->boolean('status');
            $table->date('kadaluarsa_member');
            $table->date('kadaluarsa_member');
            $table->timestamps();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email_pegawai')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
        Schema::dropIfExists('password_resets');
    }

    

};
