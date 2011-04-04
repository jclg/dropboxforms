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


function random_string($length = 6) {
  return substr(sha1(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$&()-_+=abcdefghijklmnopqrstuvwxyz1234567890'), 16)), 0, $length);
}

function insert_form($u, $oauth_token, $oauth_token_secret) {
  $db = Db::getInstance();
  return $db->query("INSERT INTO forms (u, oauth_token, oauth_token_secret) VALUES('" . $u . "', '" . $oauth_token . "', '" . $oauth_token_secret . "')");
}

function check_form($u) {
  $db = Db::getInstance();
  $u = $db->escape($u);
  $res = $db->query("SELECT u FROM forms WHERE u LIKE '" . $u . "'");
  if (!($res))
    return FALSE;
  $result = $db->fetch($res);
  if (empty($result))
    return FALSE;
  return TRUE;
}

function get_tokens($u) {
  $db = Db::getInstance();
  $u = $db->escape($u);
  $res = $db->query("SELECT oauth_token, oauth_token_secret FROM forms WHERE u LIKE '" . $u . "'");
  if (!($res))
    return FALSE;
  $result = $db->fetch($res);
  if (empty($result))
    return FALSE;
  return $result;
}

?>