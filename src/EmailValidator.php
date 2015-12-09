<?php
namespace Assignment;

class EmailValidator extends Validator
{
	protected function validate($value){
		return !filter_var($value, FILTER_VALIDATE_EMAIL) === false ? $this->value = filter_var($value, FILTER_VALIDATE_EMAIL) : $this->errorMessage = 'Not a valid email address';
	}
}