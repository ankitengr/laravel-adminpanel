<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use DB;
use Auth;
class AdminController extends Controller
{
	
	public function index(){
		$theme = $this->theme;
        return view($theme . '.index', compact('theme'));
	}
}
