<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('grades')->delete();

        \DB::table('grades')->insert(array (
            0 =>
            array (
                'created_at' => '2023-02-08 10:22:48',
                'disable' => 0,
                'id' => 7,
                'name' => 'C001',
                'program' => 'Mặc định',
                'lessons'=>30,
                'status' => 0,
                'thumbnail' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
                'time' => 10000,
                'times' => '[{"day":"","start":"","end":""}]',
                'updated_at' => '2023-02-08 10:22:48',
            ),
            1 =>
            array (
                'created_at' => '2023-02-08 11:35:32',
                'disable' => 0,
                'id' => 8,
                'lessons'=>30,
                'name' => 'C002',
                'program' => 'Mặc định',
                'status' => 0,
                'thumbnail' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
                'time' => 10000,
                'times' => '[{"day":"","start":"","end":""}]',
                'updated_at' => '2023-02-08 11:35:32',
            ),
            2 =>
            array (
                'created_at' => '2023-02-08 12:19:25',
                'disable' => 0,
                'id' => 9,
                'name' => 'C003',
                'lessons'=>30,
                'program' => 'Mặc định',
                'status' => 0,
                'thumbnail' => 'https://static.vecteezy.com/system/resources/previews/010/090/153/non_2x/back-to-school-square-frame-with-classic-yellow-pencil-with-eraser-on-it-the-pencils-are-arranged-in-a-circle-against-a-green-school-chalkboard-illustration-design-with-copy-space-free-vector.jpg',
                'time' => 10000,
                'times' => '[{"day":"","start":"","end":""}]',
                'updated_at' => '2023-02-08 12:19:25',
            ),
        ));


    }
}
