<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\sclass;
use App\Models\sstudent;
use App\Models\sfees;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create school classes
        $classes = [
            ['c_name' => 'Class 1', 'fees' => 15000.00, 'discount' => 5.00, 'status' => 1],
            ['c_name' => 'Class 2', 'fees' => 16000.00, 'discount' => 5.00, 'status' => 1],
            ['c_name' => 'Class 3', 'fees' => 17000.00, 'discount' => 7.50, 'status' => 1],
            ['c_name' => 'Class 4', 'fees' => 18000.00, 'discount' => 7.50, 'status' => 1],
            ['c_name' => 'Class 5', 'fees' => 19000.00, 'discount' => 10.00, 'status' => 1],
            ['c_name' => 'Class 6', 'fees' => 20000.00, 'discount' => 10.00, 'status' => 1],
            ['c_name' => 'Class 7', 'fees' => 22000.00, 'discount' => 12.50, 'status' => 1],
            ['c_name' => 'Class 8', 'fees' => 24000.00, 'discount' => 12.50, 'status' => 1],
            ['c_name' => 'Class 9', 'fees' => 26000.00, 'discount' => 15.00, 'status' => 1],
            ['c_name' => 'Class 10', 'fees' => 28000.00, 'discount' => 15.00, 'status' => 1],
        ];

        foreach ($classes as $classData) {
            sclass::create($classData);
        }

        // Create sample students
        $students = [
            ['name' => 'Rahul Sharma', 'father_name' => 'Rajesh Sharma', 'mobile' => '9876543210', 'email' => 'rahul@example.com', 'gender' => 'male', 'class_id' => 1],
            ['name' => 'Priya Singh', 'father_name' => 'Amit Singh', 'mobile' => '9876543211', 'email' => 'priya@example.com', 'gender' => 'female', 'class_id' => 1],
            ['name' => 'Aryan Kumar', 'father_name' => 'Suresh Kumar', 'mobile' => '9876543212', 'email' => 'aryan@example.com', 'gender' => 'male', 'class_id' => 2],
            ['name' => 'Kavya Patel', 'father_name' => 'Ravi Patel', 'mobile' => '9876543213', 'email' => 'kavya@example.com', 'gender' => 'female', 'class_id' => 2],
            ['name' => 'Vikram Gupta', 'father_name' => 'Anil Gupta', 'mobile' => '9876543214', 'email' => 'vikram@example.com', 'gender' => 'male', 'class_id' => 3],
            ['name' => 'Sneha Reddy', 'father_name' => 'Kiran Reddy', 'mobile' => '9876543215', 'email' => 'sneha@example.com', 'gender' => 'female', 'class_id' => 3],
            ['name' => 'Arjun Mehta', 'father_name' => 'Deepak Mehta', 'mobile' => '9876543216', 'email' => 'arjun@example.com', 'gender' => 'male', 'class_id' => 4],
            ['name' => 'Isha Agarwal', 'father_name' => 'Sunil Agarwal', 'mobile' => '9876543217', 'email' => 'isha@example.com', 'gender' => 'female', 'class_id' => 4],
            ['name' => 'Rohan Verma', 'father_name' => 'Pradeep Verma', 'mobile' => '9876543218', 'email' => 'rohan@example.com', 'gender' => 'male', 'class_id' => 5],
            ['name' => 'Ananya Joshi', 'father_name' => 'Vikash Joshi', 'mobile' => '9876543219', 'email' => 'ananya@example.com', 'gender' => 'female', 'class_id' => 5],
            ['name' => 'Karthik Nair', 'father_name' => 'Ramesh Nair', 'mobile' => '9876543220', 'email' => 'karthik@example.com', 'gender' => 'male', 'class_id' => 6],
            ['name' => 'Divya Iyer', 'father_name' => 'Gopal Iyer', 'mobile' => '9876543221', 'email' => 'divya@example.com', 'gender' => 'female', 'class_id' => 6],
            ['name' => 'Ravi Krishnan', 'father_name' => 'Mohan Krishnan', 'mobile' => '9876543222', 'email' => 'ravi@example.com', 'gender' => 'male', 'class_id' => 7],
            ['name' => 'Meera Srinivasan', 'father_name' => 'Venkat Srinivasan', 'mobile' => '9876543223', 'email' => 'meera@example.com', 'gender' => 'female', 'class_id' => 7],
            ['name' => 'Suresh Menon', 'father_name' => 'Kumar Menon', 'mobile' => '9876543224', 'email' => 'suresh@example.com', 'gender' => 'male', 'class_id' => 8],
        ];

        foreach ($students as $studentData) {
            $student = sstudent::create($studentData);

            // Add some fee payments for some students
            if (rand(1, 3) === 1) { // 1/3 chance of having fees
                $class = sclass::find($studentData['class_id']);
                $totalFees = $class->fees;
                
                // Random payment amount (partial or full)
                $paymentAmount = $totalFees > 0 ? rand(5000, $totalFees) : 0;
                $extraDiscount = rand(0, 500); // Random extra discount
                
                if ($paymentAmount > 0) {
                    sfees::create([
                        'student_id' => $student->id,
                        'fees_submitted' => $paymentAmount,
                        'extra_discount' => $extraDiscount,
                        'date_of_submitted' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                    ]);
                }
            }
        }
    }
}