<?php

use Illuminate\Database\Seeder;
use App\Model\Posts;

class PostsSeeder extends Seeder
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
		factory(Posts::class, $count)->create();
    }
}
