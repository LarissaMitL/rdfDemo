<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function login(){
		$user = Input::get('user');
		$passwort = Input::get('passwort');
var_dump($user);
print(Hash::make($passwort));
//print($passwort);
//die();

		if (Auth::attempt(array('username' => $user, 'password' => $passwort)))
		{
			$user = Auth::getUser();

			if($user->admin){
				print("YAY!");
				return Redirect::to('/home');
			}
		
		 	print("eingeloggt");
			return Redirect::back();
		}
		else{ 
			print("Passwort oder Username falsch");
		}

	}

	public function logout()
	{
		Auth::logout();
		return Redirect::to('/tidbit');
	}

}
