<?php

  /**
   * @file   Db.class.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Mon Apr  4 12:15:04 2011
   * 
   * @brief  
   * 
   * 
   */


require_once 'config/config.php';

class Db {
  private $_link;
  private static $_instance = null;

  private function __construct() {
    $this->_link = false;
  }

  public static function getInstance() {
    if(is_null(self::$_instance)) {
      self::$_instance = new Db();
    }
    return self::$_instance;
  }


  function connect($sql_host, $sql_user, $sql_pass, $sql_db) {
    $this->_link = mysql_connect($sql_host, $sql_user, $sql_pass);
    if (!$this->_link)
      return false;
    if (!(mysql_select_db($sql_db, $this->_link)))
      return false;
    return (true);
  }
  
  function close() {
    return mysql_close($this->_link);
  }

  function query($query) {
    return mysql_query($query, $this->_link);
  }

  function fetch($resource) {
    return mysql_fetch_array($resource);
  }

  function escape($str) {
    return mysql_real_escape_string($str);
  }

}

?>