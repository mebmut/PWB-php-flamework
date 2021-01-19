<?php
namespace App\Queries;

use Core\Model;
use Core\Validation;

class SetDatabase extends Model {
  public $dbname, $dbhost, $dbpass, $dbuser;
  protected static $_table = 'tmp_fake';

  public function validator(){
    $this->runValidation(new validation($this,'required','dbname@database name','required'));
    $this->runValidation(new validation($this,'required','dbuser@databaase user','required'));
    $this->runValidation(new Validation($this,'required','dbhost@database host','required'));
  }
  public function save(){
    if (!file_exists(ROOT.'app'.DS.'settings'.DS.'database.json')) {
       $data = '{'."\n";
         $data .= '   "dbhost" : "'.$this->dbhost.'",'."\n";
         $data .= '   "dbname" : "'.$this->dbname.'",'."\n";
         $data .= '   "dbuser" : "'.$this->dbuser.'",'."\n";
         $data .= '   "dbpass" : "'.$this->dbpass.'"'."\n";
       $data .= '}'."\n";
       $handle = fopen(ROOT.'app'.DS.'settings'.DS.'database.json',write);
       if (fwrite($handle,$data)) {
        return true;
      }
    }
  }


}
 