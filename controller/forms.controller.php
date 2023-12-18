<?php 

class FormsController {

	static public function ctrCreateUser($data){
		$createUser = FormsModels::mdlCreateUser($data);
		return $createUser;
	}
	
}
