<?php
namespace Assignment;

class URLValidator extends Validator
{
	protected function validate($value){
		return !filter_var($value, FILTER_VALIDATE_URL) === false ? $this->value = filter_var($value, FILTER_VALIDATE_URL) : $this->errorMessage = 'Not a valid url';
	}
}