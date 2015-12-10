<?php
namespace Assignment;

class ValidatorSet extends Collection
{
	private $errors = array();

	public function addItem(Validator $item, $key = null){
		parent::addItem($item, $key);
	}

	public function getErrors(){
		foreach($this->members as $key => $value){
			if(!is_null($value->getError())){
				$this->errors[$key] = $value->getError();
			}
		}
		return $this->errors;
	}
}