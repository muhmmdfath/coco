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
        Schema::create('part_data', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->date('tanggal_sortir');
            $table->string('part_number', 50);
            $table->string('lot_number', 50);
            $table->string('jenis_problem', 100)->nullable();
            $table->string('metode_sortir_rework', 50);
            $table->string('line', 50);
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('total_waktu');
            $table->string('pic_sortir_rework', 100);
            $table->integer('total_check');
            $table->integer('total_ok')->nullable();
            $table->integer('total_ng')->nullable();
            $table->date('tanggal_ambil');
            $table->date('target_selesai');
            $table->text('remark')->nullable();
            $table->string('status', 20)->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_data');
    }
};
