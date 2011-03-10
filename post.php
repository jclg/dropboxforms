<?php
  /**
   * @file   post.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Thu Mar 10 18:34:54 2011
   * 
   * @brief  
   * 
   * 
   */


include_once 'config.php';
include_once 'common.php';

$vcontent = array();
$vcontent['main'] = '';

if (!(isset($_POST['u']))) {
    $vcontent['main'] .= "OOpssss";
    render('default', $vcontent);
  }
$u = htmlentities($_POST['u']);

// On recupere les tokens dans la bdd
$link = sql_connect($conf['sql']['host'], $conf['sql']['user'], $conf['sql']['password'], $conf['sql']['db']);
if (!$link)
  die('Connexion impossible...');
if (!($tokens = get_tokens($u))) {
    $vcontent['main'] .= "OOopss Can't find that form";
    mysql_close($link);
    render('default', $vcontent);
  }
mysql_close($link);




//Verifier si le fichier recu est goodard

if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
    $vcontent['main'] .= 'Erreur lors de l\'upload du fichier';
    render('default', $vcontent);
 }

if (move_uploaded_file($_FILES['file']['tmp_name'], "/tmp/" . $_FILES['file']['name']) === FALSE) {
  $vcontent['main'] .= 'Erreur lors du deplacement du fichier';
  render('default', $vcontent);
 }
$file = "/tmp/" . $_FILES['file']['name'];

     
$timestamp = time();
$oauth_timestamp = $timestamp;
$oauth_nonce= md5($timestamp);
//calculate signature key
$sign_array = array (
		     'oauth_signature_method'=>'HMAC-SHA1',
		     'oauth_nonce'=>md5($timestamp),
		     'oauth_timestamp'=>$timestamp,
		     'oauth_token'=>$tokens['oauth_token'],
		     'oauth_consumer_key'=>$consumerKey,
		     'oauth_version'=>'1.0',
		     'file'=> urlencode($file),
		     );
ksort($sign_array);
$normalized = array();
foreach ($sign_array as $key => $value) {
  $normalized[] = $key.'='.$value;
}
$string_array = implode('&', $normalized);
$url = 'https://api-content.dropbox.com/0/files/dropbox/';
$sig = array ('POST', $url, $string_array);
$base_string = implode('&', array_map('urlencode', $sig));
$key =  $consumerSecret . '&' . $tokens['oauth_token_secret'];
$signature = base64_encode(hash_hmac("sha1", $base_string, $key, true));



$post_array = array();
$post_array = $sign_array;
$post_array['file'] = "@$file";
$post_array['oauth_signature'] = $signature;

 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);



if (strpos($data, 'winner!') !== FALSE) {
  $vcontent['main'] .= '---<br />
  The file ' . htmlentities(basename($file)) . ' is now in the Dropbox :)
  <br />---<br />
  <a href="up.php?u=' . $u . '">Upload another file</a>
';
 }
else {
    $vcontent['main'] .= 'Something goes wrong from Dropbox :S<br />
    <a href="up.php?u=' . $u . '">Retry to upload file</a>
';
  }

// rm du fichier tmp
@unlink($file);

render('default', $vcontent);

?>