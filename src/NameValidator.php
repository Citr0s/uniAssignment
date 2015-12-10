<?php
namespace Assignment;

class NameValidator extends Validator
{
	protected function validate($value){
		$this->value = filter_var($value, FILTER_SANITIZE_STRING);
		
		if(strlen($this->value) > 25 || strlen($this->value) < 0){
			$this->errorMessage = 'This name is too long';
		}
	}
}