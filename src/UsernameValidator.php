<?php
namespace Assignment;

class UsernameValidator extends Validator
{
	protected function validate($value){
		$this->value = filter_var($value, FILTER_SANITIZE_STRING);
		
		if(strlen($this->value) > 20 || strlen($this->value) < 0){
			$this->errorMessage = 'This username has invalid length';
		}
	}
}