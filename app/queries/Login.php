<?php
namespace App\Queries;

use Core\Model;
use Core\Validation;

class login extends Model {
  public $username, $password, $remember_me;
  protected static $_table = 'tmp_fake';

  public function validator(){
    $this->runValidation(new validation($this,'required','username','required'));
    $this->runValidation(new Validation($this,'required','password','required'));
  }

  public function getRememberMeChecked(){
    return $this->remember_me == 'on';
  }
}
