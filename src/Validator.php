<?php
namespace Assignment;

abstract class Validator
{
	protected $errorMessage;
	protected $value;
	protected $minLength;
	protected $maxLength;
	protected $required;

	public function __construct($value, $required = false, $min = 5, $max = 25){
		if(!empty($value)){
			$this->minLength = $min;
			$this->maxLength = $max;
			$this->validate($value);
		}else{
			if($required){
				$this->errorMessage = 'This is a required field';
			}
		}
	}

	public function hasError(){
		return isset($this->errorMessage);
	}

	public function getError(){
		return $this->errorMessage;
	}

	public function getSanitisedValue(){
		return htmlentities($this->value);
	}
	abstract protected function validate($value);
}