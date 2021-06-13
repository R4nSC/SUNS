<?php
 
use Illuminate\Database\Seeder;
 
class UsersTableSeeder extends Seeder
{
 
    public function run()
    {
        DB::table('users')->truncate();
 
        DB::table('users')->insert([
            [
                'name'      => 'TestA',
                'email'       => 'TestAbody@test',
                'password'   => 'userA',
                'created_at' => '2016-08-12 14:00:00',
                'updated_at' => '2016-08-12 14:00:00',
            ],
            [
                'name'      => 'TestB',
                'email'       => 'TestBbody@test',
                'password'   => 'userB',
                'created_at' => '2016-08-12 14:03:00',
                'updated_at' => '2016-08-12 14:03:00',
            ],
            [
                'name'      => 'TestC',
                'email'       => 'TestCbody@test',
                'password'   => 'userC',
                'created_at' => '2016-08-12 14:06:00',
                'updated_at' => '2016-08-12 14:06:00',
            ],
        ]);
    }
}