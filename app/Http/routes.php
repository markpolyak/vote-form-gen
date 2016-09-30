<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() {
//	return view('auth/login');

	return Redirect::to('auth/login');
});

Route::get('home', function(){
	if (Auth::guest()){
//		return view('auth/login');
		return Redirect::to('auth/login');
	} else {
//	return view('meetings');
	return Redirect::to('meetings');
	}
});

Route::get('meetings', function () {
	return view('meetings');
});

Route::get('getblank', function (){
	//принимаем тип метода и ид юзера
	$method = Request::method();
	//Заглушка для неавторизованных пользователей
	//begin
	if (\Auth::guest()) { $id_user = 1; }
	else { $id_user = Auth::user()->id; } //без заглушки останется только эта строка
	//end
	if (Request::isMethod('get'))
	{//принимаем значение id_met
		$id_met = Input::get('id_met');
		return redirect('http://vote-form-gen.onlinemkd.ru/REC/GenPDF.php?id_meeting='.$id_met.'&id_user='.$id_user);
	}	 
});

Route::get('unregblank', function () {
	return view('unregblank');
});

Route::post('datmet', function () {
	return view('datmet');
});

Route::post('datmet', 'DatmetController@GetMet');

Route::filter('csrf-ajax',function()
{
	if (Session::token() != Request::header('x-csrf-token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::get('unregblank', 'UnregblankController@ShowAll');

Route::get('meetings', 'MeetingController@ShowAll');

Route::get('user/{id}', function($id){
	$user = App\User::find($id);
	echo 'The user with ID of ' . $id . ' has an email of: ' . $user->email;
});


//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');
//маршруты аутенфикации пользователей 
Route::get('auth/login', 'Auth\AuthController@getLogin');


Route::post('auth/login', 'Auth\AuthController@postLogin');
//выход пользователя из аккаунта
Route::get('auth/logout', 'Auth\AuthController@getLogout');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
