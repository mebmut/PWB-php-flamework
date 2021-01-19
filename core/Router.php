<?php
namespace Core;

use Core\View;
use Core\Request;

class Router{
  
    public function __construct(){
        $this->view = new View;
        $this->request = new Requests;
        $this->onConstruct();
    }

    public function onConstruct(){}

    public static function redirect($location) {
      if(!headers_sent()) {
        header('Location: '.URLROOT.$location);
        exit();
      } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.URLROOT.$location.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
        echo '</noscript>';exit;
      }
    }
}
