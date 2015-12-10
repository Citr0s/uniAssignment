<?php
namespace Assignment;

use Assignment\Database;
use Assignment\DatabaseSession;
use Assignment\ValidatorSet;
use Assignment\User;

class Registration
{
	private $dbCon;
	private $session;
	private $user;
	private $valSet;

	public function __construct($data){
		$this->dbCon = new Database();
		$this->session = new DatabaseSession($this->dbCon);
		$this->user = new User();
		$this->valSet = new ValidatorSet();

		foreach($data as $key => $value){
		  $this->valSet->addItem($value, $key);
		}

		if(empty(self::getErrors())){
		  if(!$this->sessionExists(session_id())){
		  	$this->sessionCreate(session_id(), $data['username']->getSanitisedValue());
		    $this->user->save($data);
		    $this->user->login($data);
		  }
		}
	}

	private function sessionExists($session_id){
		return $this->session->read($session_id);
	}

	private function sessionCreate($session_id, $data){
		return $this->session->write($session_id, $data);
	}

	public function getErrors(){
		return $this->valSet->getErrors();
	}

	
}