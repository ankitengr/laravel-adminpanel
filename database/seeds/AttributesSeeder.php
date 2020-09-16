<?php

use Illuminate\Database\Seeder;
use App\Attributes;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $count = 1;
       factory(Attributes::class, $count)->create();
    }
}
