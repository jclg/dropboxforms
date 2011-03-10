<?php
  /**
   * @file   auth_ok.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Thu Mar 10 18:33:35 2011
   * 
   * @brief  
   * 
   * 
   */

session_start();

include_once 'config.php';
include_once 'common.php';

$vcontent = array();
$vcontent['main'] = '';

$tokens = $_SESSION['oauth_tokens'];

$url = 'http://api.dropbox.com/0/oauth/access_token?oauth_consumer_key=' . $consumerKey . '&oauth_token=' . $tokens['oauth_token'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$data = curl_exec($ch);
curl_close($ch);



if (strpos($data, 'error') !== FALSE) {
  $vcontent['main'] .= 'Oops, it seems you are not associated with your dropbox account :(';
  $vcontent['main'] .= '<br /><a href="auth.php">Click here to retry</a>';
 }
 else {
   if (!isset($_SESSION['u'])) {
     parse_str($data, $tokens);
     $_SESSION['oauth_tokens'] = $tokens;
     $_SESSION['u'] = random_string();
     $link = sql_connect($conf['sql']['host'], $conf['sql']['user'], $conf['sql']['password'], $conf['sql']['db']);
     if (!$link)
       die('Connexion impossible...');
     insert_row($_SESSION['u'], $tokens['oauth_token'], $tokens['oauth_token_secret']);
     mysql_close($link);
   }

   $url_form = $conf['url'] . 'up.php?u=' . $_SESSION['u'];
   $vcontent['main'] .= 'Cool, you are associated. Here is the link to your upload form: <br />
   <a href="' . $url_form . '" target="_blank">' . $url_form . '</a>
   <br />You can give this link to your friends ^^';
 }

render('default', $vcontent);

?>
