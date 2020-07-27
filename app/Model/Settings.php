<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    //
	protected $fillable = ['option_name','option_value','allow_edit','status'];
}
