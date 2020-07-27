<?php

use Illuminate\Database\Seeder;
use App\Model\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $count = 1;
       factory(Settings::class, $count)->create();
	}
}
