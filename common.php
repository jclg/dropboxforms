<?php
  /**
   * @file   common.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Thu Mar 10 18:33:51 2011
   * 
   * @brief  Common functions
   * 
   * 
   */

function render($view, $content) {
  $cview = 'views/' . $view . '.php';
  if (file_exists($cview))
    require_once $cview;
  else
    echo "Bad view $view ($cview)";
  exit (0);
}

function random_string($length = 6) {
  return substr(sha1(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$&()-_+=abcdefghijklmnopqrstuvwxyz1234567890'), 16)), 0, $length);
}

function sql_connect($sql_host, $sql_user, $sql_pass, $sql_db) {
  $link = mysql_connect($sql_host, $sql_user, $sql_pass);
  if (!$link)
    return false;
  if (!(mysql_select_db($sql_db, $link)))
    return false;
  return ($link);
}

function sql_close($link) {
  return mysql_close($link);
}

function insert_row($u, $oauth_token, $oauth_token_secret) {
  return mysql_query("INSERT INTO forms (u, oauth_token, oauth_token_secret) VALUES('" . $u . "', '" . $oauth_token . "', '" . $oauth_token_secret . "')");
}

function check_u($u) {
  $u = mysql_real_escape_string($u);
  $res = mysql_query("SELECT u FROM forms WHERE u LIKE '" . $u . "'");
  if (!($res))
    return FALSE;
  $result = mysql_fetch_array($res);
  if (empty($result))
    return FALSE;
  return TRUE;
}

function get_tokens($u) {
  $u = mysql_real_escape_string($u);
  $res = mysql_query("SELECT oauth_token, oauth_token_secret FROM forms WHERE u LIKE '" . $u . "'");
  if (!($res))
    return FALSE;
  $result = mysql_fetch_array($res);
  if (empty($result))
    return FALSE;
  return $result;
}

?>