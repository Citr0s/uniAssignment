<?php
namespace Assignment;

class DateValidator extends Validator
{
	protected function validate($value){
		$date = strtotime($value);
		$year = 365 * 86400;
		$eighteenFromToday = time() - ($year * 18);

		if($date > time() || $date > $eighteenFromToday){
			$this->errorMessage = 'Age not allowed';
		}
		return true;
	}
}