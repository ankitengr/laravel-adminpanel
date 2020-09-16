<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //add this line

class RelationalValues extends Model
{
    //
	use SoftDeletes; //add this line
	protected $fillable = [
        'content', 'attribute_id', 'content_id', 'entity_type'
    ];
	
}
