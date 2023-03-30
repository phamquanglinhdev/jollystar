<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('logs')->delete();

        \DB::table('logs')->insert(array(
            0 =>
                array(
                    'attachments' => 'https://bizsoft.com.vn/test/download/sample.pdf',
                    'created_at' => '2023-03-17 14:37:36',
                    'date' => '2023-03-17',
                    'end' => '16:30:00',
                    'grade_id' => 7,
                    'id' => 5,
                    'no' => 1,
                    'lesson' => 'Animal In the Zoo',
                    'question' => '2 bé kể về các loại động vật trong sở thú',
                    'salary_per_hour' => 200000,
                    'start' => '15:30:00',
                    'students' => '[{"name":"Tr\\u1ea7n B\\u00ecnh Minh","present":"1","comment":"B\\u00e9 h\\u1ecdc t\\u1eadp trung , c\\u00f3 t\\u01b0 duy t\\u1ed1t"},{"name":"L\\u00e3 Th\\u1ecb T\\u1ed1 Ng\\u00e2n","present":"1","comment":"B\\u00e9 h\\u1ecdc \\u1ed5n, t\\u1ef1 gi\\u00e1c l\\u00e0m b\\u00e0i"}]',
                    'teacher_comment' => '2 Bé đều học rất tốt',
                    'teacher_id' => 2,
                    'updated_at' => '2023-03-17 15:34:50',
                    'video' => '{"provider":"youtube","id":"v0yqE7UMr0Y","title":"Học Tiếng Anh cùng Ms Jeanly Patalinghug.","image":"https://i.ytimg.com/vi/v0yqE7UMr0Y/maxresdefault.jpg","url":"https://www.youtube.com/watch?v=v0yqE7UMr0Y"}',
                ),
        ));


    }
}
