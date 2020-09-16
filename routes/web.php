<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
	'prefix'=>'admin',
	'middleware' => 'auth'
	 ],function(){
		Route::get('/','Admin\AdminController@index')->name('admin.index');
	});

Route::group([
	'prefix'=>'admin',
	'middleware' => 'auth',
	'namespace'	=> 'Admin',
	 ],function(){
		/*Route::get('/', function () {
			return view('welcome');
		});*/
		
		
		
		/******** ACL and User Management *****/
		
		Route::resource('users', 'UsersController');
		Route::resource('roles', 'RolesController');
		Route::resource('permission', 'PermissionController');
		
		Route::resource('posttypes', 'PostTypesController');
		Route::resource('categories', 'CategoriesController');
		Route::resource('templates', 'TemplatesController');
		Route::resource('widgets', 'WidgetsController');
		
		Route::resource('multimedia', 'MultimediaController');
		
		Route::resource('ajax', 'AjaxController');
		Route::post('ajax/get_medias', 'AjaxController@get_medias');
		Route::post('ajax/get_media_data/{id}', 'AjaxController@get_media_data');
		Route::post('ajax/media_upload', 'AjaxController@media_upload');
				
		
		Route::resource('settings','SettingsController');
		Route::get('settings/create/{option_key}', ['middleware' => ['ability:superadministrator|administrator,create-settings'], 'uses' => 'SettingsController@create'])->name('settings.create');
		
		Route::resource('apps', 'AppsController');
		Route::resource('attributesgroup', 'AttributesGroupController');
		Route::resource('attributes', 'AttributesController');
		Route::resource('attributesmapping', 'AttributesMappingController');
		Route::resource('authors', 'AuthorsController');
		//Route::resource('attribute_multi_data_values', 'AttributeMultiDataValuesController');
		
		
		/****Posts Multiple route by type ****/
		$post_type = DB::table('post_types')
			        ->select('title','slug')
			        ->where('published','=','1')
			        ->orderBy('id')
			        ->get();
		
	
		foreach ($post_type as $key =>$value) {
			Route::resource('posts/'.$value->slug, 'PostsController');	
		}
		
		
		
		/*
		Route::get('user/create', ['middleware' => ['ability:superadministrator|administrator,create-users'], 'uses' => 'UsersController@create'])->name('users.create');
		Route::get('user/edit/{id}', ['middleware' => ['ability:superadministrator|administrator,read-users'], 'uses' => 'UsersController@edit'])->name('users.edit');
		Route::get('user/show/{id}', ['middleware' => ['ability:superadministrator|administrator,read-users'], 'uses' => 'UsersController@show'])->name('users.show');
		Route::put('user/update/{id}', ['middleware' => ['ability:superadministrator|administrator,update-users'], 'uses' => 'UsersController@update'])->name('users.update');
		Route::delete('user/delete/{id}', ['middleware' => ['ability:superadministrator|administrator,delete-users'], 'uses' => 'UsersController@destroy'])->name('users.destroy');
		
		
		Route::resource('roles', 'RolesController');
		/*
		Route::get('role/create', ['middleware' => ['ability:superadministrator|administrator,create-roles'], 'uses' => 'RolesController@create'])->name('roles.create');
		Route::get('role/edit/{id}', ['middleware' => ['ability:superadministrator|administrator,read-roles'], 'uses' => 'RolesController@edit'])->name('roles.edit');
		Route::get('role/show/{id}', ['middleware' => ['ability:superadministrator|administrator,read-roles'], 'uses' => 'RolesController@show'])->name('roles.show');
		Route::put('role/update/{id}', ['middleware' => ['ability:superadministrator|administrator,update-roles'], 'uses' => 'RolesController@update'])->name('roles.update');
		Route::delete('role/delete/{id}', ['middleware' => ['ability:superadministrator|administrator,delete-roles'], 'uses' => 'RolesController@destroy'])->name('roles.destroy');
		
        
		
		Route::resource('permission', 'PermissionController');
		/*
		Route::get('permission/create', ['middleware' => ['ability:superadministrator|administrator,create-permission'], 'uses' => 'PermissionController@create'])->name('permission.create');
		Route::get('permission/edit/{id}', ['middleware' => ['ability:superadministrator|administrator,read-permission'], 'uses' => 'PermissionController@edit'])->name('permission.edit');
		Route::get('permission/show/{id}', ['middleware' => ['ability:superadministrator|administrator,read-permission'], 'uses' => 'PermissionController@show'])->name('permission.show');
		Route::put('permission/update/{id}', ['middleware' => ['ability:superadministrator|administrator,update-permission'], 'uses' => 'PermissionController@update'])->name('permission.update');
		Route::delete('permission/delete/{id}', ['middleware' => ['ability:superadministrator|administrator,delete-permission'], 'uses' => 'PermissionController@destroy'])->name('permission.destroy');
		*/
		
		/******** ACL and User Management End *****/
		
		
		/**Theme Purpose**/
		/*
		Route::get('logout','LoginController@logout')->name('admin.logout');*/
		//Route::post('delete','CommonController@delete')->name('delete');
		//Route::post('status_change','CommonController@status_change')->name('status_change');
		
		/**Theme Purpose End**/
		
		
		/**** Self Development ***/
		//Route::resource('general','GeneralController');
		//Route::get('general_ajax','GeneralController@ajax_data')->name('general_ajax');
		//Route::get('general/listing/table:{table}','GeneralController@listing')->name('general_listing');
		
		
		
		
		
		/*
		Route::get('general/table:{table}','Admin\GeneralController@index')->name('general');
	
		Route::resource('users','Admin\UsersController');
		Route::get('users','Admin\UsersController@index')->name('users.index');
		Route::get('user/create','Admin\UsersController@create')->name('users.create');
		Route::get('user/edit/{id}','Admin\UsersController@edit')->name('users.edit');
		
		///**Need to check if below required
		Route::get('/home','Admin\AdminController@index')->name('home');
		
		Route::post('delete','Admin\CommonController@delete')->name('delete');
		Route::post('status_change','Admin\CommonController@status_change')->name('status_change');
		*/
		
	});

/*
Route::group(['middleware' => ['web']], function () {
	Route::get('storage/{filename}', function ($filename) {
			//$userid = session()->get('user')->id;
			return Storage::get('uploads/' . $filename);
	});
});
*/


Auth::routes();
Route::get('/login', 'LoginController@index')->name('login');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
