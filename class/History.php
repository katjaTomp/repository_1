<?php
class History extends User{

protected $module;
protected $date;
protected $user_name;

function __constract($module_name, $user_name){
	$this->module=$module_name;
	$this->user_name=$user_name;
	
}

function updateHistory($username,$module_name){

	$q="Update history Set user_name='".$username."',date=NOW() WHERE module_name='".$module_name."'";
	$pdo=new PDOAccess();
	$stmt=$pdo->getPDO()->prepare($q);
	if($stmt->execute()){
		return true;
	}
	else {
		return "there was a problem with updating the history.";
	}


}

/**
* lastModifiedBy returns the user id who has last used the module
*
* params module_name
* @return int or string
*/

function lastModifiedBy($module_name){
	$q="SELECT user_name FROM history WHERE module_name='".$module_name."'";
	$pdo=new PDOAccess();
	$stmt=$pdo->getPDO()->prepare($q);
	$stmt->execute();

	if($row=$stmt->fetch()){
		foreach($row as $name=>$value){
			return $user_name=$value;
		}

	}else{
		return 'No recent modification has been made.';
	}

}

function lastModification($user_id){}

/**
* history log the information of the last actions of the module
* 
* params module_name
* @return array
**/

function getModuleHistory($module_name){

	$q="SELECT user_name,filename,datetime,environment FROM actions WHERE module_name='".$module_name."'";
	$pdo=new PDOAccess();
	$stmt=$pdo->getPDO()->prepare($q);
	if($stmt->execute()){
		$results=$stmt->fetch();
		return $results;
	}
	else{return "";}

}
function updateActions($username,$module,$file,$env){
	
	$env=($env=="development" ?'dev':'stg');

	$q="INSERT into actions (user_name,module_name,filename,datetime,environment) VALUES('$username','$module','$file',NOW(),'$env')";
	$pdo=new PDOAccess();
	$stmt=$pdo->getPDO()->prepare($q);
	if($stmt->execute()){
		return true;
	}
	else {
		return false;
	}
}
	

}
?>
