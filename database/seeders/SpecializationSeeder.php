<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Specializations for nafaqa channel
        $nafaqaSpecializations = [
            'علوم حاسوب',
            'هندسة برمجيات',
            'نظم معلومات',
            'ذكاء اصطناعي'
        ];

        foreach ($nafaqaSpecializations as $name) {
            Specialization::create([
                'name' => $name,
                'channel' => 'nafaqa'
            ]);
        }

        // Specializations for ejaza channel
        $ejazaSpecializations = [
            'علوم رياضيات',
            'فيزياء تطبيقية',
            'كيمياء تحليلية',
            'أحياء جزيئية'
        ];

        foreach ($ejazaSpecializations as $name) {
            Specialization::create([
                'name' => $name,
                'channel' => 'ejaza'
            ]);
        }
    }
}
