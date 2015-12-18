<?php
namespace Assignment;

class AgeValidator extends Validator
{
	protected function validate($value){
		$this->value = filter_var($value, FILTER_VALIDATE_INT);
		
		if($this->value <= $this->minLength || $this->value >= $this->maxLength){
			$this->errorMessage = 'Age not allowed';
		}
	}
}