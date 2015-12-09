<?php
namespace Assignment;

class ValidatorSet extends Collection
{
	private $errors = array();
	public function getErrors(){
		foreach($this->members as $key => $value){
			if(!is_null($value->getError())){
				$errors[$key] = $value->getError();
			}
		}
		return $errors;
	}
}