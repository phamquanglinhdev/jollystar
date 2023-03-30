<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array(
            0 =>
                array(
                    'avatar' => 'https://files.catbox.moe/mt8vsg.png',
                    'created_at' => '2023-02-08 05:07:17',
                    'disable' => 0,
                    'email' => 'admin@jollystar.com',
                    'email_verified_at' => NULL,
                    'extras' => NULL,
                    'facebook_id' => 'ok',
                    'github_id' => 'ok',
                    'google_id' => 'ok',
                    'id' => 1,
                    'name' => 'Admin Jolly Star',
                    'parent' => NULL,
                    'password' => '$2y$10$Q6acDsMlCXwg8dpW11O5LOHhUXGSH0keNiAz2Yo8ZNaL7uK1Otm0u',
                    'phone' => NULL,
                    'remember_token' => NULL,
                    'role' => 'admin',
                    'updated_at' => '2023-02-08 05:07:17',
                ),
        ));
    }
}
