<?php
namespace Assignment;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
	public function test_adding_item_to_collection(){
		$coll = new Collection();
		$actual = $coll->addItem('Test Item');

		$this->assertTrue($actual);
	}

	public function test_adding_item_with_key_to_collection(){
		$coll = new Collection();
		$actual = $coll->addItem('Test Item', 1);

		$this->assertTrue($actual);
	}

	public function test_adding_two_items_with_two_different_keys_to_collection(){
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->addItem('Test Two', 2);

		$this->assertTrue($actual);
	}

	public function test_adding_two_items_to_collection(){
		$coll = new Collection();
		$coll->addItem('Test Item');
		$actual = $coll->addItem('Test Two');

		$this->assertTrue($actual);
	}

	public function test_adding_item_that_already_exists(){
		$this->setExpectedException('UnexpectedValueException');

		$coll = new Collection();
		$coll->addItem('Test Item 1', 1);
		$actual = $coll->addItem('Test Item 2', 1);
	}

	public function test_removing_item_from_collection(){
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->removeItem(1);

		$this->assertTrue($actual);
	}

	public function test_removing_non_existent_item_from_collection(){
		$this->setExpectedException('UnexpectedValueException');

		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->removeItem(2);
	}

	public function test_getting_item_from_collection(){
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->getItem(1);

		$expected = 'Test Item';

		$this->assertEquals($expected, $actual);
	}

	public function test_getting_non_existent_item_from_collection(){
		$this->setExpectedException('UnexpectedValueException');
		
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->getItem(2);
	}

	public function test_getting_array_of_keys(){
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$coll->addItem('Test Item', 2);
		$actual = $coll->keys();

		$expected = array(1, 2);

		$this->assertEquals($expected, $actual);
	}

	public function test_checking_if_exists(){
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->exists(1);

		$this->assertTrue($actual);
	}

	public function test_checking_if_doesnt_exists(){
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->exists(2);

		$this->assertFalse($actual);
	}

	public function test_size(){
		$coll = new Collection();
		$coll->addItem('Test Item', 1);
		$actual = $coll->length();

		$expected = 1;

		$this->assertEquals($expected, $actual);
	}

	public function test_iterator(){
		$coll = new Collection();
		$coll->addItem('HelloWorld');
		$count = 0;
		foreach($coll as $item) {
			$count++;
		}
		$this->assertEquals(1, $count);
	}

	public function test_iterator_remove_item_2()
	{
		$actual = '';
		$coll = new Collection();
		$coll->addItem('HelloWorld1', 'msg1');
		$coll->addItem('HelloWorld2');
		foreach($coll as $key=>$item) {
			if($key == 'msg1') {
				$coll->removeItem($key);
				$actual = $item;
			}
		}
	$this->assertEquals('HelloWorld2', $actual);
	}
}