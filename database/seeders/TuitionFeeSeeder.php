<?php

namespace Database\Seeders;

use App\Models\TuitionFee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TuitionFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fees = [
            [
                'semester' => 1,
                'year' => 2025,
                'fee_name' => 'ค่ากิจกรรมกีฬาสี',
                'rate_money' => 250.00,
            ],
            [
                'semester' => 1,
                'year' => 2025,
                'fee_name' => 'ค่าบำรุงห้องสมุด',
                'rate_money' => 100.00,
            ],
            [
                'semester' => 1,
                'year' => 2025,
                'fee_name' => 'ค่าบำรุงพยาบาล',
                'rate_money' => 50.00,
            ],
            [
                'semester' => 1,
                'year' => 2025,
                'fee_name' => 'ค่าประกันอุบัติเหตุ',
                'rate_money' => 150.00,
            ],
        ];

        foreach ($fees as $fee) {
            TuitionFee::firstOrCreate($fee);
        }
    }
}