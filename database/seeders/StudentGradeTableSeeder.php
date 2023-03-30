<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StudentGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('student_grade')->delete();
        
        \DB::table('student_grade')->insert(array (
            0 => 
            array (
                'created_at' => '2023-03-17 14:26:41',
                'current' => 350000,
                'deadline' => '2023-04-17',
                'grade_id' => 7,
                'id' => 1,
                'payment' => 1,
                'pricing' => 500000,
                'promotion' => 5,
                'start' => '2023-03-17',
                'status' => 0,
                'student_id' => 4,
                'updated_at' => '2023-03-17 14:26:41',
            ),
            1 => 
            array (
                'created_at' => '2023-03-17 14:30:09',
                'current' => 500000,
                'deadline' => NULL,
                'grade_id' => 7,
                'id' => 2,
                'payment' => 0,
                'pricing' => 500000,
                'promotion' => 0,
                'start' => '2023-03-17',
                'status' => 0,
                'student_id' => 8,
                'updated_at' => '2023-03-17 14:30:09',
            ),
        ));
        
        
    }
}