<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['name' => 'ปวช.1'],
            ['name' => 'ปวช.2'],
            ['name' => 'ปวช.3'],
            ['name' => 'ปวส.1'],
            ['name' => 'ปวส.2'],
            ['name' => 'ป.ตรี'],
        ];

        foreach ($levels as $level) {
            Level::firstOrCreate($level);
        }
    }
}
