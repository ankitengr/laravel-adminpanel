<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PosttypeModel extends Model
{
    //
    protected $fillable = ['name','full_name','status'];
    protected $table = 'post_type';

    public function get_fillable() {
    	return $this->fillable;
    }
}
