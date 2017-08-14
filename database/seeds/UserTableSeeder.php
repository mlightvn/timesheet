<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('user')->delete();
		\App\Model\User::create(array(
			'name'     => 'グエン・ナム',
			'email'    => 'nguyen.nam@urban-funes.co.jp',
			'session_id'    => '1',
			'session_is_manager'    => 'Member',
			'password' => Hash::make('1'),
		));
    }
}
