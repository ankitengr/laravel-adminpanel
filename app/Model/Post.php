<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line

class Post extends Model
{
    //
	use SoftDeletes; //add this line
	protected $fillable = [
        'post_types_id', 'app_id', 'title', 'slug', 'description', 'publish_up', 'publish_down'
    ];
}
