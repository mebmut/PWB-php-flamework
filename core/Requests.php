<?php
namespace Core;

use Core\Session;
use Core\Router;

class Requests{
	
 public function isPost(){
    return $this->getRequestMethod() === 'POST';
  }

  public function isSet($request){
    return isset($_POST[$request]);
  }

  public function isPut(){
    return $this->getRequestMethod() === 'PUT';
  }
  
  public function isGet(){
    return $this->getRequestMethod() === 'GET';
  }

  public function getRequestMethod(){
    return strtoupper($_SERVER['REQUEST_METHOD']);
  }

  public function get($input=false) {
    if(!$input){
      // return entire request array and sanitize it
      $data = [];
      foreach($_REQUEST as $field => $value){
        $data[$field] = trim(sanitize($value));
      }
      return $data;
    }

    return (array_key_exists($input,$_REQUEST))?trim(sanitize($_REQUEST[$input])) : '';
  }

  public function csrfCheck(){
    if(!Session::checkToken($this->get('csrf_token'))) Router::redirect('restricted/badToken');
    return true;
  }

}