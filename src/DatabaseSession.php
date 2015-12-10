<?php
namespace Assignment;

class DatabaseSession implements \SessionHandlerInterface {
  private $dbConn;
  private $table;
  
  public function __construct(Database $dbConn, $table = 'sessions'){
    $this->dbConn = $dbConn;
    $this->table = $table;
    
    session_set_save_handler(
      array($this, 'open'),
      array($this, 'close'),
      array($this, 'read'),
      array($this, 'write'),
      array($this, 'destroy'),
      array($this, 'gc')
    );
  }

  public function open($save_path, $name){
    return true;
  }

  public function close(){
    return true;
  }

  public function read($session_id){
    $parameters = array(
              'table' => $this->table,
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

  public function write($session_id, $session_data, $modified = null){
    $modified = !is_null($modified) ? $modified : time(); 
    $parameters = array(
              'table' => $this->table,
              'fields' => array(
                              array(
                                'session_id' => $session_id,
                                'data' => $session_data,
                                'modified' => $modified,
                              ),
                            ),
          );

    return $this->dbConn->insert($parameters);
  }

  public function destroy($session_id){
    $parameters = array(
              'table' => $this->table,
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
    $expectedTime = time() - $maxlifetime;
    $parameters = array(
              'table' => $this->table,
              'conditions' => array(
                        array(
                          'field' => 'modified',
                          'operator' => '<',
                          'value' => $expectedTime,
                        ),
                    ),
          );
    return $this->dbConn->delete($parameters);
  }
}