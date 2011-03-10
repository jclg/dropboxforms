<?php
  /**
   * @file   up.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Thu Mar 10 18:34:59 2011
   * 
   * @brief  
   * 
   * 
   */

include_once 'config.php';
include_once 'common.php';

$vcontent = array();
$vcontent['main'] = '';

if (!(isset($_GET['u'])) || $_GET['u'] == '') {
    $vcontent['main'] .= "OOpssss";
  }
 else {
     $u = htmlentities($_GET['u']);

     $link = sql_connect($conf['sql']['host'], $conf['sql']['user'], $conf['sql']['password'], $conf['sql']['db']);
     if (!$link)
       die('Connexion impossible...');
     if (!(check_u($u))) {
	 $vcontent['main'] .= "OOpssss Can't find that form";
	 mysql_close($link);
       }
     else {
	 mysql_close($link);
	 $vcontent['main'] .= '
<form method="post" action="post.php" enctype="multipart/form-data">
     <input type="hidden" name="u" id="u" value="' . $u . '" />
     <input type="file" name="file" id="file" /><br />
     <input type="submit" value="Uploader" />
</form>
';
     }
 }

render('default', $vcontent);
?>


