<?php
namespace Assignment;

use Assignment\Database;

class User
{
	private $dbCon;
	public function __construct(){
		$this->dbCon = new Database();
	}

	public function save($details){
		$values = array();
		foreach($details as $detail){
			$values[] = $detail->getSanitisedValue();
		}

		$parameters = array(
		    			'table' => 'userdetails',
		    			'fields' => array(
		    							array(
			    							'username' => $values[0],
			    							'password' => sha1($values[1]),
			    							'email' => $values[2],
			    							'url' => $values[3],
			    							'dob' => $values[4],
		    							),
		    						),
					);

		return $this->dbCon->insert($parameters);
	}

	public function login($data){
		$_SESSION['user'] = $data;
	}

	public function isLoggedIn(){
		return isset($_SESSION['user']);
	}
}