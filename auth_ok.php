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

include_once 'config/config.php';
include_once 'utils/common.php';
include_once 'classes/Db.class.php';
include_once 'classes/Renderer.class.php';


$content = '';

$tokens = $_SESSION['oauth_tokens'];

$url = 'http://api.dropbox.com/0/oauth/access_token?oauth_consumer_key=' . $consumerKey . '&oauth_token=' . $tokens['oauth_token'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$data = curl_exec($ch);
curl_close($ch);



if (strpos($data, 'error') !== FALSE) {
  $content .= 'Oops, it seems you are not associated with your dropbox account :(';
  $content .= '<br /><a href="auth.php">Click here to retry</a>';
 }
 else {
   if (!isset($_SESSION['u'])) {
     parse_str($data, $tokens);
     $_SESSION['oauth_tokens'] = $tokens;
     $_SESSION['u'] = random_string();


     $db = Db::getInstance();

     if (!$db->connect($conf['sql']['host'], $conf['sql']['user'], $conf['sql']['password'], $conf['sql']['db'])) {
       echo 'can\'t connect to db';
       return;
     }
     insert_form($_SESSION['u'], $tokens['oauth_token'], $tokens['oauth_token_secret']);
     $db->close();
   }

   $url_form = $conf['url'] . 'up.php?u=' . $_SESSION['u'];
   $content .= 'Cool, you are associated. Here is the link to your upload form: <br />
   <a href="' . $url_form . '" target="_blank">' . $url_form . '</a>
   <br />You can give this link to your friends ^^';
 }


$renderer = new Renderer();
$renderer->setContent($content);
$renderer->render();

?>
