<?php
namespace Assignment;

class DateValidator extends Validator
{
	protected function validate($value){
		$this->value = $value;
		$date = strtotime($this->value);
		$year = 365 * 86400;
		$minAge = time() - ($year * $this->minLength);

		if($date > time() || $date > $minAge){
			$this->errorMessage = 'Age not allowed';
		}
		return true;
	}
}