<?php
namespace Assignment;

use mysqli;

require_once 'config.php';

class DatabaseTest extends \PHPUnit_Framework_TestCase
{
	private static $db;

    public static function setUpBeforeClass(){
        self::$db = new mysqli(host, username, password, database);
        self::$db->query("CREATE TABLE books (
    										id int NOT NULL AUTO_INCREMENT,
    										isbn varchar(13),
    										title varchar(255),
    										author varchar(255),
    										PRIMARY KEY (id))"
    									);

        $record = "INSERT INTO books (isbn, title, author) VALUES 
        													('9780605039070', 'Harry Potter and the Deathly Hallows', 'J. K. Rowling'),
        													('9780747560722', 'Harry Potter and the Chamber of Secrets', 'J. K. Rowling'),
        													('9780007117116', 'The Lord of the Rings', 'J. R. R. Tolkien'),
        													('9780553386790', 'A Game of Thrones', 'George R. R. Martin')
        												";
        self::$db->query($record);
    }

	public function setUp(){
		$this->instance = new Database();
	}

	public function tearDown(){
		unset($this->instance);
	}

	public static function tearDownAfterClass(){
		self::$db->query("DROP TABLE books");
		self::$db = NULL;
	}

	public function test_selecting_all_records_one_field(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array('title'),
					);

		$expected = array(
					    array('title' => 'Harry Potter and the Deathly Hallows'),
					    array('title' => 'Harry Potter and the Chamber of Secrets'),
					    array('title' => 'The Lord of the Rings'),
					    array('title' => 'A Game of Thrones'),
					);

		$this->assertEquals($expected, $this->instance->select($parameters));
	}

	public function test_selecting_all_records_many_fields(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array('title', 'author'),
					);

		$expected = array(
					    array(
					    	'title' => 'Harry Potter and the Deathly Hallows',
					    	'author' => 'J. K. Rowling',
					    ),
					    array(
					    	'title' => 'Harry Potter and the Chamber of Secrets',
					    	'author' => 'J. K. Rowling',
					    ),
					    array(
					    	'title' => 'The Lord of the Rings',
					    	'author' => 'J. R. R. Tolkien',
					    ),
					    array(
					    	'title' => 'A Game of Thrones',
					    	'author' => 'George R. R. Martin',
					    ),
					);

		$this->assertEquals($expected, $this->instance->select($parameters));
	}

	public function test_selecting_all_records_all_fields(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array('title', 'author', 'isbn'),
					);

		$expected = array(
					    array(
					    	'title' => 'Harry Potter and the Deathly Hallows',
					    	'author' => 'J. K. Rowling',
					    	'isbn' => '9780605039070',
					    ),
					    array(
					    	'title' => 'Harry Potter and the Chamber of Secrets',
					    	'author' => 'J. K. Rowling',
					    	'isbn' => '9780747560722',
					    ),
					    array(
					    	'title' => 'The Lord of the Rings',
					    	'author' => 'J. R. R. Tolkien',
					    	'isbn' => '9780007117116',	
					    ),
					    array(
					    	'title' => 'A Game of Thrones',
					    	'author' => 'George R. R. Martin',
					    	'isbn' => '9780553386790',
					    ),
					);

		$this->assertEquals($expected, $this->instance->select($parameters));
	}

	public function test_selecting_all_records_one_field_one_condition(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array('author'),
		    			'conditions' => array(
		    								array(
	    										'field' => 'title',
	    										'operator' => '=',
	    										'value' => 'A Game of Thrones',
	    									),
	    								),
					);

		$expected = array(
					    array('author' => 'George R. R. Martin'),
					);

		$this->assertEquals($expected, $this->instance->select($parameters));
	}

	public function test_selecting_all_records_one_field_two_conditions(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array('title'),
		    			'conditions' => array(
		    								array(
	    										'field' => 'author',
	    										'operator' => '=',
	    										'value' => 'J. K. Rowling',
    										),
			    							array(
												'field' => 'isbn',
												'operator' => '=',
												'value' => '9780605039070',
											),
										),
					);

		$expected = array(
					    array('title' => 'Harry Potter and the Deathly Hallows'),
					);

		$this->assertEquals($expected, $this->instance->select($parameters));
	}

	public function test_selecting_non_existent_records(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array('title'),
		    			'conditions' => array(
		    								array(
	    										'field' => 'author',
	    										'operator' => '=',
	    										'value' => '',
    										)
										),
					);

		$this->assertFalse($this->instance->select($parameters));
	}

	public function test_selecting_wrong_parameters(){
		$this->setExpectedException('InvalidArgumentException');

		$parameters = array('foo' => 'bar');

		$this->instance->select($parameters);
	}

	public function test_inserting_one_record(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array(
		    							array(
			    							'isbn' => '9780582186552',
			    							'title' => 'The Hobbit',
			    							'author' => 'J. R. R. Tolkien',
		    							),
		    						),
					);

		$this->assertTrue($this->instance->insert($parameters));
	}

	public function test_inserting_two_records(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array(
		    							array(
			    							'isbn' => '9780582186552',
			    							'title' => 'The Hobbit',
			    							'author' => 'J. R. R. Tolkien',
			    						),
		    							array(
			    							'isbn' => '9783764531027',
			    							'title' => 'A Dance With Dragons',
			    							'author' => 'George R. R. Martin',
			    						),
			    					),
					);

		$this->assertTrue($this->instance->insert($parameters));
	}

	public function test_inserting_wrong_parameters(){
		$this->setExpectedException('InvalidArgumentException');

		$parameters = array('foo' => 'bar');

		$this->instance->insert($parameters);
	}

	public function test_updating_all_records_one_field(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array(
		    							array('isbn' => '100'),
		    						),
					);

		$this->assertTrue($this->instance->update($parameters));
	}

	public function test_updating_all_records_two_fields(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array(
		    							array('isbn' => '200'),
		    							array('title' => 'Example Book'),
		    						),
					);

		$this->assertTrue($this->instance->update($parameters));
	}

	public function test_updating_one_record_one_field_one_condition(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array(
		    							array('isbn' => '9780553386790'),
		    						),
		    			'conditions' => array(
		    								array(
	    										'field' => 'author',
	    										'operator' => '=',
	    										'value' => 'George R. R. Martin',
	    									),
	    								),
					);

		$this->assertTrue($this->instance->update($parameters));
	}

	public function test_updating_one_record_one_field_two_conditions(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array(
		    							array('isbn' => '9780553386790'),
		    						),
		    			'conditions' => array(
		    								array(
	    										'field' => 'author',
	    										'operator' => '=',
	    										'value' => 'George R. R. Martin',
	    									),
	    									array(
	    										'field' => 'title',
	    										'operator' => '=',
	    										'value' => 'Example Book',
	    									),
	    								),
					);

		$this->assertTrue($this->instance->update($parameters));
	}

	public function test_updating_non_existent_records(){
		$parameters = array(
		    			'table' => 'books',
		    			'fields' => array(
	    								array('isbn' => '9780553386790'),
	    							),
		    			'conditions' => array(
		    								array(
	    										'field' => 'foo',
	    										'operator' => '=',
	    										'value' => 'bar',
    										)
										),
					);

		$this->assertFalse($this->instance->update($parameters));
	}

	public function test_updating_wrong_parameters(){
		$this->setExpectedException('InvalidArgumentException');

		$parameters = array('foo' => 'bar');

		$this->instance->update($parameters);
	}

	public function test_deleting_one_record_one_condition(){
		$parameters = array(
		    			'table' => 'books',
		    			'conditions' => array(
		    								array(
	    										'field' => 'title',
	    										'operator' => '=',
	    										'value' => 'Example Book',
    										),
										),
					);

		$this->assertTrue($this->instance->delete($parameters));
	}

	public function test_deleting_one_record_two_condition(){
		$parameters = array(
		    			'table' => 'books',
		    			'conditions' => array(
		    								array(
	    										'field' => 'title',
	    										'operator' => '=',
	    										'value' => 'Example Book',
    										),
    										array(
	    										'field' => 'isbn',
	    										'operator' => '=',
	    										'value' => '200',
    										),
										),
					);

		$this->assertTrue($this->instance->delete($parameters));
	}

	public function test_deleting_wrong_parameters(){
		$parameters = array(
		    			'table' => 'foo',
					);

		$this->assertFalse($this->instance->delete($parameters));
	}

	public function test_deleting_all_records(){
		$parameters = array(
		    			'table' => 'books',
					);

		$this->assertTrue($this->instance->delete($parameters));
	}
}