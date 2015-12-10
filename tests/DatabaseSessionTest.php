<?php
namespace Assignment;

use mysqli;
use Assignment\Database;

require_once 'config.php';

class DatabaseSessionTest extends \PHPUnit_Framework_TestCase
{
	private static $db;
	private $dbConn;
	private $session;

    public static function setUpBeforeClass(){
        self::$db = new mysqli(host, username, password, database);
        self::$db->query("CREATE TABLE IF NOT EXISTS testSessions (
    										id int NOT NULL AUTO_INCREMENT,
    										session_id varchar(13),
    										data varchar(255),
    										modified varchar(255),
    										PRIMARY KEY (id))"
    									);
    }

	public function setUp(){
		$this->dbCon = new Database();
		$this->session = new DatabaseSession($this->dbCon, 'testSessions');
	}

	public function tearDown(){
		unset($this->dbCon);
		unset($this->session);
	}

	public static function tearDownAfterClass(){
		self::$db->query("DROP TABLE testSessions");
		self::$db = NULL;
	}

	public function test_writing_session_data(){
		$this->assertTrue($this->session->write(1, 'test', '1449760698'));
	}

	public function test_reading_session_data(){
		$expected = array(
					    array(
					    	'id' => '1',
					    	'session_id' => '1',
					    	'data' => 'test',
					    	'modified' => '1449760698',
					    ),
					);

		$this->assertEquals($expected, $this->session->read(1));
	}

	public function test_deleting_session_data(){
		$this->assertTrue($this->session->destroy(1));
	}
}