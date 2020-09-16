<?php

use Illuminate\Database\Seeder;
use App\Model\Posttypes;

class PostTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$count = 1;
		factory(PostTypes::class, $count)->create();
    }
}
