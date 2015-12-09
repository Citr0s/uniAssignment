<?php
namespace Assignment;

use mysqli;
use InvalidArgumentException;

require_once 'config.php';

class Database
{
	private $connection;

	public function __construct(){
		$this->connect();
	}

	private function connect(){
		$this->connection = new mysqli(host, username, password, database);
	}

	private function getFieldsString($fields){
		$returnArray = array();

		if($fields === '*'){
			$returnArray = array('*');
		}else{
			foreach($fields as $field){
				$returnArray[] = "`" . $field . "`";
			}
		}

		return implode(', ', $returnArray);
	}

	private function getWhereString($fields){
		$returnString = '';
		if(isset($fields['conditions'])){
			$whereString = array();
			foreach($fields['conditions'] as $field){
				if(is_numeric($field['value'])){
					$value = $field['value'];
				}else{
					$value = "'" . $field['value'] . "'";
				}
				$whereString[] = "`" .$field['field'] . "`" . $field['operator'] . $value;
			}
			$returnString = ' WHERE ' . implode(' AND ', $whereString);
		}
		return $returnString;
	}

	private function getValuesString($fields){
		$valuesArray = array();
		$fieldsArray = array();
		foreach($fields as $field){
			foreach($field as $key => $value){
				if(is_numeric($value)){
					$val = $value;
				}else{
					$val = "'" . $value . "'";
				}
				$tempFieldsArray[] = "`" . $key . "`";
				$tempValuesArray[] = $val;
			}
			$fieldsArray = array(); //reset fieldsArray as we only want one set
			$fieldsArray[] = "(" . implode(', ', $tempFieldsArray) . ")";
			$valuesArray[] = "(" . implode(', ', $tempValuesArray) . ")";
			$tempFieldsArray = array();
			$tempValuesArray = array();
		}

		$returnString = implode(', ', $fieldsArray) . "VALUES" . implode(', ', $valuesArray);
		return $returnString;
	}

	private function getSetString($fields){
		$returnArray = array();

		foreach($fields as $field){
			foreach($field as $key => $value){
				if(is_numeric($value)){
					$val = $value;
				}else{
					$val = "'" . $value . "'";
				}

				$returnArray[] = "`" . $key . "`=" . $val;
			}
		}

		return implode(', ', $returnArray);
	}

	public function select($parameters){
		
		if(!isset($parameters['fields']) || !isset($parameters['table'])){
			throw new InvalidArgumentException('Invalid parameters passed.');
		}

		$sql = "SELECT " . $this->getFieldsString($parameters['fields']) 
			. " FROM `{$parameters['table']}`" 
			. $this->getWhereString($parameters);

		$returnArray = array();
		$results = $this->connection->query($sql);

		if($results){
			while($row = $results->fetch_assoc()){
				$returnArray[] = $row;
			}
		}

		if(empty($returnArray)){
		    return false;
		}else{
		    return $returnArray;
		}
	}

	public function insert($parameters){
		
		if(!isset($parameters['table']) || !isset($parameters['fields'])){
			throw new InvalidArgumentException('Invalid parameters passed.');
		}

		$sql = "INSERT INTO `{$parameters['table']}` " . $this->getValuesString($parameters['fields']);
		$results = $this->connection->query($sql);

		if($results){
		    return true;
		}else{
		    return false;
		}
	}

	public function update($parameters){
		
		if(!isset($parameters['table']) || !isset($parameters['fields'])){
			throw new InvalidArgumentException('Invalid parameters passed.');
		}

		$sql = "UPDATE `{$parameters['table']}` SET " . $this->getSetString($parameters['fields']) . $this->getWhereString($parameters);
		$results = $this->connection->query($sql);

		return $results;
	}

	public function delete($parameters){
		
		if(!isset($parameters['table'])){
			throw new InvalidArgumentException('Invalid parameters passed.');
		}

		$sql = "DELETE FROM `{$parameters['table']}`". $this->getWhereString($parameters);
		$results = $this->connection->query($sql);

		return $results;
	}
}
