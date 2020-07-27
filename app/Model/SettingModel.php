<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    //
    protected $fillable = ['option_name','option_value'];
    protected $table = 'setting_data';

    public function get_fillable() {
    	return $this->fillable;
    }
}
