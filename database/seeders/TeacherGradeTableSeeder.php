<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TeacherGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('teacher_grade')->delete();
        
        \DB::table('teacher_grade')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'grade_id' => 8,
                'teacher_id' => 2,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'grade_id' => 7,
                'teacher_id' => 2,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'grade_id' => 7,
                'teacher_id' => 6,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'grade_id' => 9,
                'teacher_id' => 6,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}