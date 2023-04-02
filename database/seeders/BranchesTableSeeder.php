<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('branches')->delete();
        
        \DB::table('branches')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Chi nhánh 1',
                'code' => '1',
                'created_at' => '2023-04-02 12:45:31',
                'updated_at' => '2023-04-02 12:45:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Chi nhánh 2',
                'code' => '2',
                'created_at' => '2023-04-02 12:45:40',
                'updated_at' => '2023-04-02 12:45:40',
            ),
        ));
        
        
    }
}