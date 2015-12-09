<?php
namespace Assignment;

use Iterator;
use UnexpectedValueException;

class Collection implements Iterator
{
	protected $members = array();
	private $position = 0;

	public function addItem($item, $key = null){
		if(is_null($key)){
			$this->members[] = $item;
		}else{
			if(array_key_exists($key, $this->members)){
				throw new UnexpectedValueException('Value with this key already exists!');
			}else{
				$this->members[$key] = $item;
			}
		}

		return true;
	}
	public function removeItem($key)
	{
		if(array_key_exists($key, $this->members)){
			 unset($this->members[$key]);
			 return true;
		}else{
			throw new UnexpectedValueException('Value with this key doesn\'t exists!');
		}
	}
	public function getItem($key)
	{
		if(array_key_exists($key, $this->members)){
			 return $this->members[$key];
		}else{
			throw new UnexpectedValueException('Value with this key doesn\'t exists!');
		}
	}
	public function keys()
	{
		return array_keys($this->members);
	}
	public function exists($key)
	{
		if(array_key_exists($key, $this->members)){
			 return true;
		}else{
			return false;
		}
	}
	public function length()
	{
		return sizeof($this->members);
	}
	public function current()
	{
		return $this->members[$this->position];
	}
	public function key()
	{
		return $this->position;
	}
	public function next()
	{
		$this->position++;
	}
	public function rewind()
	{
		$this->position = 0;
	}
	public function valid()
	{
		if(array_key_exists($this->position, $this->members)){
			 return true;
		}else{
			return false;
		}
	}
}