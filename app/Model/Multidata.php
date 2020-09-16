<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line

class Multidata extends Model
{
    //
	use SoftDeletes; //add this line
	protected $fillable = [
        'content'
    ];
}
