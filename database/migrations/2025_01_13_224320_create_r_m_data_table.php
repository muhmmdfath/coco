<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rm_data', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->date('tanggal_sortir');
            $table->string('rm_number', 50);
            $table->string('lot_number', 50);
            $table->string('jenis_problem', 100)->nullable();
            $table->string('metode_sortir_rework', 50);
            $table->string('line', 50);
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('total_waktu');
            $table->string('pic_sortir_rework', 100);
            $table->integer('total_check');
            $table->integer('diameter_besar')->nullable();
            $table->integer('diameter_sedang')->nullable();
            $table->integer('diameter_kecil')->nullable();
            $table->integer('total_ok')->nullable();
            $table->integer('total_ng')->nullable();
            $table->text('remark')->nullable();
            $table->string('departement_pic_sortir', 100)->nullable();
            $table->string('status', 20)->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_data');
    }
};
