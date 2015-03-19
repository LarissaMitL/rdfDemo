<?php 

class AdminController extends BaseController {

public function showStart()
	{
		$tidbits = Tidbit::where('id', '>', 0)->get();
		return View::make('adminbit', array('tidbits' => $tidbits));
	} 
?>