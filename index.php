<?php
  /**
   * @file   index.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Thu Mar 10 18:34:45 2011
   * 
   * @brief  
   * 
   * 
   */

session_start();
session_destroy();
include_once 'classes/Renderer.class.php';



$content = '
	  <div class="step">
	    1. Log into Dropbox.<br /><br /><br /><br />
	    <img src="img/dropbox-icon.png" alt="" />
	  </div>
	  <div class="step">
	    2. Get your link to an upload form.<br /><br /><br /><br />
	    <img src="img/upload.png" alt="" />
	  </div>
	  <div class="step">
	    3. Share the link with your friends.<br />They can send files directly in your Dropbox.<br /><br />
	    <img src="img/share.png" alt="" />
	  </div>
      </div>

      <div id="under_box">
	<div id="go">
	  <a href="auth.php">Let\'s start</a><br />
	</div>
';

$renderer = new Renderer();
$renderer->setContent($content);
$renderer->render();

?>
