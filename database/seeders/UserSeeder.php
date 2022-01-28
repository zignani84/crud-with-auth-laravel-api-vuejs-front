<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$datetime = date('Y-m-d H:i:s');

		DB::table('users')->insert(
			[
				'id' => '1',
				'name' => 'Administrador',
				'email' => 'admin@teste.com.br',
				'password' => bcrypt('@dmin1234'),
				'remember_token' => Str::random(10),
				'first_login' => 'N', 
				'created_at' => $datetime,
				'updated_at' => $datetime,
			]
		);
    }
}