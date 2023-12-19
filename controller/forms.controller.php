<?php 

class FormsController {

	static public function ctrCreateUser($data){
		$createUser = FormsModels::mdlCreateUser($data);
		return $createUser;
	}

	static public function ctrGetUsers(){
		$getUser = FormsModels::mdlGetUsers();

    	return json_encode($getUser);
	}
	
}
