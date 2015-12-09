<?php
namespace Assignment;

class DatabaseSession implements \SessionHandlerInterface {
  private $dbConn;
  public function __construct(Database $dbConn){
    //session_set_save_handler();
    $this->dbConn = $dbConn;
  }

  public function open($save_path, $name){
    return true;
  }

  public function close(){
    return true;
  }

  public function read($session_id){
    $parameters = array(
              'table' => 'sessions',
              'fields' => '*',
              'conditions' => array(
                        array(
                          'field' => 'session_id',
                          'operator' => '=',
                          'value' => $session_id,
                        ),
                      ),
          );

    return $this->dbConn->select($parameters);
  }

  public function write($session_id, $session_data){
    $parameters = array(
              'table' => 'sessions',
              'fields' => array(
                              array(
                                'session_id' => $session_id,
                                'data' => $session_data,
                              ),
                            ),
          );

    return $this->dbConn->insert($parameters);
  }

  public function destroy($session_id){
    $parameters = array(
              'table' => 'sessions',
              'conditions' => array(
                        array(
                          'field' => 'session_id',
                          'operator' => '=',
                          'value' => $session_id,
                        ),
                    ),
          );

    return $this->dbConn->delete($parameters);
  }

  public function gc($maxlifetime){
    //enter your garbage collection functionality here
    //Garbage collector. This function is called periodically
    //according to a preset probability.
    //Depending upon website traffic this is
    //usually set to 1/1000. It removes all sessions
    //that haven’t been modified for the preset
    //$maxlifetime timestamp
    //(a session should be deleted if its timestamp is
    //less than time() - $maxlifetime).
  }
}