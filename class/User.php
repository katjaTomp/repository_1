<?php

class User{
	
	private $email;
	private $name;
	private $lastname;
	private $username;
	private $active;
	private $id;
	

	function __constract(){}

	function create_user(array $params){

			if (is_New()){

				//create the query with the colomns

				foreach($params as $name =>$value){
					if($value!=''){
						$colns.=$name.',';
						$values.='"'.$value.'",';
		            }
	            }
				$colns=trim($colns,',');
				$values=trim($values,',');
				$query="INSERT INTO user ($colns) VALUES ($values)";
				$pdo=new PDOAccess();
				$stmt=$pdo->getPDO()->prepare($query);
				if($stmt->execute()){
					//retrieve the user id which was automatically created in order to insert the values into access
					$user_email=$params['email'];
					$id=self::getId($user_email);
					return $id;
					}
		    else {
		    	return "not possible to create a new user";
		    }
        }    
			
			else{

				 return "This user already exists in the system";
			}


	}


/**
* is_New method checks if the user already exists in the system
*
* params an email of the new user
* @return boolean
*/

	private function is_New($email){

			$query="Select id from user WHERE email='".$email."'";
			$stmt=$pdo->prepare($query);
			$stmt->execute();

			if($stmt->fetch()){
				return false;
			}
			else return true;
	}

/**
* getId retrieves the id from DB
*
* params user email
* @return int OR bolean
*/

function getId($email){
	$q="SELECT id from user WHERE email='".$email."'";
	$pdo=new PDOAccess();
	$stmt=$pdo->getPDO()->prepare($q);
	$stmt->execute();
	$row=$stmt->fetch();
		foreach($row as $name=>$value){
					$id=$value;
					return $id;
	}
	return 'fail to find the user';
}

/**
* insert into access table the assigned modules
*
* params user id
* @return boolean
*/

function assignModules($id,$module){
  foreach($module as $name=>$value){
		if($value!=""){
			
				$query="INSERT INTO access(id,module_name,user_id)VALUES ($id,'$value',$id)"; 
				$pdo=new PDOAccess();
				$stmt=$pdo->getPDO()->prepare($query);
				if($stmt->execute()){return true;}
				else {return false;}
			

		}
	}

}

/**
* update user table
*
* params the array with the user info
* @return boolean
*/

function updateAdmin($user,$user_id){

	//update the user table in DB
	foreach($user as $name=> $value){
		if($value!==''){ 
			$query="UPDATE user SET $name ='$value' WHERE id= ".$user_id;
		
        	$pdo=new PDOAccess();
			$stmt=$pdo->getPDO()->prepare($query);
        	return $stmt->execute(); 
	}
}
}

function updateAccess(array $module, $user_id){
	foreach($module as $name=>$value){
	//if the module checkbox is  unchecked 
	if($value=='') {
			   
	 			$query="DELETE FROM access WHERE (module_name='$name'and user_id=$user_id)";
				$pdo=new PDOAccess();
			    $stmt=$pdo->getPDO()->prepare($query);
				$stmt->execute();

		}
	//if the module is checked	
	if($value!=''){
		
           	try{
            	
	 			$query="INSERT INTO access (id,module_name,user_id) VALUES ($user_id,'$value',$user_id)";
				$pdo=new PDOAccess();
			    $stmt=$pdo->getPDO()->prepare($query);
				$stmt->execute();
		
			}
			catch(Exception $e){}

			}
		
			}

}

function updateProfile(array $post,$session_id){

	foreach($post as $name=> $value){
	if($value!==''){ 
		$query="UPDATE user SET $name ='$value' WHERE id=".$session_id;
		
        $pdo=new PDOAccess();
		$stmt=$pdo->getPDO()->prepare($query);
        $stmt->execute(); 
	}
}
header('Location: success.php');
}

}
?>
