<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$this->call(PostsSeeder::class);
		$this->call(PostTypesSeeder::class);
		$this->call(AttributesSeeder::class);
		$this->call(SettingsSeeder::class);
		$this->call(LaratrustSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
