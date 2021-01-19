<?php
namespace App\Queries;

use Core\Model;
use Core\Validation;

class SetAdmin extends Model {
  public $password , $username, $email, $confirm;
  protected static $_table = 'tmp_fake';

  public function validator(){
    $this->runValidation(new validation($this,'required','email','required'));
    $this->runValidation(new validation($this,'required','username','required'));
    $this->runValidation(new Validation($this,'required','password','required'));
    $this->runValidation(new Validation($this,'required','confirm@password confirm','required'));
  }

  public function save(){
   if (!file_exists(ROOT.'app'.DS.'settings'.DS.'admin.json')) {
      $password = password_hash($this->password, PASSWORD_DEFAULT);
      $data = '{'."\n";
        $data .= ' "admin" : {'."\n";
        $data .= '   "email" : "'.$this->email.'",'."\n";
        $data .= '   "username" : "'.$this->username.'",'."\n";
        $data .= '   "password" : "'.$password.'"'."\n";
        $data .= ' }'."\n";
      $data .= '}'."\n";
      $handle = fopen(ROOT.'app'.DS.'settings'.DS.'admin.json',write);
      if (fwrite($handle,$data)) {
        return true;
      }
   }
  }

}
 