<?php

  /**
   * @file   renderer.class.php
   * @author jc <jean-charles.le-goff@epitech.eu>
   * @date   Wed Mar 16 16:49:42 2011
   * 
   * @brief  
   * 
   * 
   */

class Renderer
{
  private $_view;
  private $_content;

  public function Renderer() {
    $this->_view = 'default';
    $this->_content = '';
  }

  public function setView($view) {
    $this->_view = $view;
  }

  public function setContent($content) {
    $this->_content = $content;
  }

  public function rprint($var) {
    echo $var;
  }

  public function partial($partial) {
    $cpartial = 'views/partials/' . $partial . '.php';
    $content = $this->_content;
    if (file_exists($cpartial))
      require_once $cpartial;
    else
      echo "Error: The 'partial view' " . $partial . " ($cpartial) doesn't exist.";
  }

  public function render() {
    $cview = 'views/' . $this->_view . '.php';
    $content = $this->_content;
    if (file_exists($cview))
      require_once $cview;
    else
      echo "Error: The 'view' " . $this->_view . " ($cview) doesn't exist.";
    exit (0);
  }

}
?>