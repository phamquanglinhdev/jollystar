<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StaffGradeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('staff_grade')->delete();
        
        \DB::table('staff_grade')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'grade_id' => 8,
                'staff_id' => 5,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'grade_id' => 7,
                'staff_id' => 3,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'grade_id' => 9,
                'staff_id' => 3,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}