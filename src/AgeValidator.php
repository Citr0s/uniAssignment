<?php
namespace Assignment;

class AgeValidator extends Validator
{
	protected function validate($value){
		$this->value = filter_var($value, FILTER_VALIDATE_INT);
		
		if($this->value <= 20 || $this->value >= 45){
			$this->errorMessage = 'Age not allowed';
		}
	}
}