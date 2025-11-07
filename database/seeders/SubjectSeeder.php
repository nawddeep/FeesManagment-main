<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ssubject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'subject_name' => 'Mathematics',
                'fees' => 5000.00,
                'discount' => 10.00,
                'description' => 'Advanced mathematics for competitive exams',
                'status' => 1,
            ],
            [
                'subject_name' => 'Physics',
                'fees' => 4500.00,
                'discount' => 5.00,
                'description' => 'Physics concepts and problem solving',
                'status' => 1,
            ],
            [
                'subject_name' => 'Chemistry',
                'fees' => 4500.00,
                'discount' => 5.00,
                'description' => 'Organic and inorganic chemistry',
                'status' => 1,
            ],
            [
                'subject_name' => 'Biology',
                'fees' => 4000.00,
                'discount' => 8.00,
                'description' => 'Botany and zoology for competitive exams',
                'status' => 1,
            ],
            [
                'subject_name' => 'Computer Science',
                'fees' => 6000.00,
                'discount' => 15.00,
                'description' => 'Programming and computer fundamentals',
                'status' => 1,
            ],
            [
                'subject_name' => 'English Literature',
                'fees' => 3500.00,
                'discount' => 0.00,
                'description' => 'English language and literature',
                'status' => 1,
            ],
            [
                'subject_name' => 'General Knowledge',
                'fees' => 3000.00,
                'discount' => 12.00,
                'description' => 'Current affairs and general knowledge',
                'status' => 1,
            ],
            [
                'subject_name' => 'Logical Reasoning',
                'fees' => 4000.00,
                'discount' => 7.50,
                'description' => 'Analytical and logical reasoning skills',
                'status' => 1,
            ],
        ];

        foreach ($subjects as $subject) {
            Ssubject::create($subject);
        }
    }
}