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

include_once 'config/config.php';
include_once 'utils/common.php';
include_once 'classes/Db.class.php';
include_once 'classes/Renderer.class.php';

$content = '';

if (!(isset($_GET['u'])) || $_GET['u'] == '') {
    $content .= "OOpssss";
  }
 else {
     $u = htmlentities($_GET['u']);

     $db = Db::getInstance();

     if (!$db->connect($conf['sql']['host'], $conf['sql']['user'], $conf['sql']['password'], $conf['sql']['db'])) {
       echo 'can\'t connect to db';
       return;
     }


     if (!(check_form($u))) {
       $content .= "OOpssss Can't find that form";
       $db->close();
       }
     else {
       $db->close();
       $content .= '
<form method="post" action="post.php" enctype="multipart/form-data">
     <input type="hidden" name="u" id="u" value="' . $u . '" />
     <input type="file" name="file" id="file" /><br />
     <input type="submit" value="Uploader" />
</form>
';
     }
 }

$renderer = new Renderer();
$renderer->setContent($content);
$renderer->render();
?>


