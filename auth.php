<?php
  /**
   * @file   auth.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Thu Mar 10 18:33:44 2011
   * 
   * @brief  
   * 
   * 
   */

session_start();

include_once 'config.php';
include_once 'common.php';


//Demande de token
$url = 'https://api.dropbox.com/0/oauth/request_token?oauth_consumer_key=' . $consumerKey;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$data = curl_exec($ch);
curl_close($ch);
parse_str($data, $tokens);
$_SESSION['oauth_tokens'] = $tokens;    


//redirection vers l'url pour auth
$url = 'http://api.dropbox.com/0/oauth/authorize?oauth_token=' . $tokens['oauth_token'] . '&oauth_callback=' . $conf['url'] . 'auth_ok.php' ;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$data = curl_exec($ch);
curl_close($ch);


$pos = strpos($data, 'href=');
$data = substr($data, $pos + strlen('href=') + 1);
$pos = strpos($data, '">');
$url_auth = substr($data, 0, $pos);
header('Location: ' . $url_auth);


?>
