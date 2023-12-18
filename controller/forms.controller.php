<?php 

class FormsController {

	static public function ctrCreateUser($data){
		$password = generarPassword();
		$createUser = FormsModels::mdlCreateUser($data);
		return $createUser;
	}
	
}
