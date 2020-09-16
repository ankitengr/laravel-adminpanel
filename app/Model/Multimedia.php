<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line

class Multimedia extends Model
{
    //
	use SoftDeletes; //add this line
	protected $fillable = [
        'trans_id', 'multimedia_type', 'file_path', 'ratio', 'file_size', 'extra'
    ];
}
