<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CaringsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('carings')->delete();
        
        \DB::table('carings')->insert(array (
            0 => 
            array (
                'created_at' => '2023-03-17 14:26:59',
                'id' => 1,
                'note' => 'Đã test , năng lực rất tốt',
                'staff_id' => 1,
                'student_id' => 4,
                'updated_at' => '2023-03-17 14:26:59',
            ),
            1 => 
            array (
                'created_at' => '2023-03-17 14:27:10',
                'id' => 2,
                'note' => 'Học thử tiềm năng',
                'staff_id' => 1,
                'student_id' => 4,
                'updated_at' => '2023-03-17 14:27:10',
            ),
            2 => 
            array (
                'created_at' => '2023-03-17 14:27:26',
                'id' => 3,
                'note' => 'Thêm vào lớp C001, đã thu 1 phần học phí',
                'staff_id' => 1,
                'student_id' => 4,
                'updated_at' => '2023-03-17 14:27:26',
            ),
            3 => 
            array (
                'created_at' => '2023-03-17 14:30:31',
                'id' => 4,
                'note' => 'Học thử 
khá tốt',
                'staff_id' => 1,
                'student_id' => 8,
                'updated_at' => '2023-03-17 14:30:31',
            ),
            4 => 
            array (
                'created_at' => '2023-03-17 14:30:48',
                'id' => 5,
                'note' => 'Đã thêm vào lớp C001, đóng đủ học phí',
                'staff_id' => 1,
                'student_id' => 8,
                'updated_at' => '2023-03-17 14:30:48',
            ),
        ));
        
        
    }
}