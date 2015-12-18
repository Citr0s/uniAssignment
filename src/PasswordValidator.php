<?php
namespace Assignment;

class PasswordValidator extends Validator
{
	protected function validate($value){
		$this->value = filter_var($value, FILTER_SANITIZE_STRING);
		
		if(strlen($this->value) > $this->maxLength || strlen($this->value) < $this->minLength){
			$this->errorMessage = 'This password has invalid length';
		}
	}
}