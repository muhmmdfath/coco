<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PartDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $data = [];
        for ($i = 0; $i < 3000; $i++) { // Ubah jumlah sesuai kebutuhan
            $waktuMulai = $faker->dateTimeBetween('-1 month', 'now');
            $waktuSelesai = $faker->dateTimeBetween($waktuMulai, '+2 hours');

            // Hitung total waktu dalam detik sebagai angka biasa
            $totalWaktu = $waktuSelesai->getTimestamp() - $waktuMulai->getTimestamp();

            $data[] = [
                'timestamp' => Carbon::now(),
                'tanggal_sortir' => $faker->date(),
                'part_number' => strtoupper($faker->lexify('PN?????')),
                'lot_number' => strtoupper($faker->lexify('LN?????')),
                'jenis_problem' => $faker->randomElement(['Crack', 'Pitting', 'Discoloration', null]),
                'metode_sortir_rework' => $faker->randomElement(['Manual', 'Automated']),
                'line' => 'Line ' . $faker->randomElement(['A', 'B', 'C']),
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,
                'total_waktu' => $totalWaktu, // Angka biasa untuk total waktu dalam detik
                'pic_sortir_rework' => $faker->name(),
                'total_check' => $faker->numberBetween(50, 500),
                'total_ok' => $faker->numberBetween(40, 490),
                'total_ng' => $faker->numberBetween(0, 50),
                'tanggal_ambil' => $faker->date(),
                'target_selesai' => $faker->date(),
                'remark' => $faker->sentence(),
                'status' => $faker->randomElement(['Pending', 'Approved', 'Disapproved']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('part_data')->insert($data);
    }
}
