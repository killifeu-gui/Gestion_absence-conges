<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    public function run(): void
    {
        $holidays = [
            ['name' => 'Nouvel An', 'date' => '2026-01-01', 'year' => 2026],
            ['name' => 'Fête du Travail', 'date' => '2026-05-01', 'year' => 2026],
            ['name' => 'Indépendance', 'date' => '2026-04-04', 'year' => 2026],
            ['name' => 'Fête de la République', 'date' => '2026-06-23', 'year' => 2026],
            ['name' => 'Tabaski', 'date' => '2026-06-14', 'year' => 2026],
            ['name' => 'Korité', 'date' => '2026-05-25', 'year' => 2026],
            ['name' => 'Mawlid', 'date' => '2026-09-15', 'year' => 2026],
        ];

        foreach ($holidays as $holiday) {
            Holiday::updateOrCreate(['date' => $holiday['date']], $holiday);
        }
    }
}
