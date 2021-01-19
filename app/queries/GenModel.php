<?php
namespace App\Queries;

use Core\{Model,Validation};

class GenModel extends Model {

     public $model='', $table, $construct = false, $afterSave = false;
     public $onConstruct = false, $validator = false, $beforeSave = false; 
     private $path = ROOT.'app'.DS.'queries'.DS;

     protected static $_table = 'tmp_fake';

     public function validator(){
          $this->runValidation(new validation($this,'required','model','required'));
          $this->runValidation(new validation($this,'required','table','required'));
          if (!empty($this->model)) {
               $this->runValidation(new validation($this,'fileExists','model',$this->path.$this->model.'.php'));
          }
     }

     public function save(){
          $model =  $this->model;
          $ext = ".php";
          $fullPath = ROOT.'app'.DS.'queries'.DS.ucfirst($model).$ext;
          $content = '<?php'."\n";
          $content .= 'namespace App\Queries;'."\n";
          $content .= ''."\n";
          $content .= 'use Core\{Model,Validation};'."\n";
          $content .= ''."\n";
          $content .= 'class '.ucfirst($model).' extends Model {'."\n";
              $content .= ''."\n";
              $content .= '     protected static $_table = \''.$this->table.'\';'."\n";
              $content .= ''."\n";
              if ($this->construct) {
               $content .= '     public function __construct(){'."\n";
                 $content .= "        //Code will go here"."\n";
               $content .= '     }'."\n";
               $content .= ''."\n";
              }
              if ($this->beforeSave) {
               $content .= '     public function beforeSave(){'."\n";
                 $content .= "        //Code will go here"."\n";
               $content .= '     }'."\n";
               $content .= ''."\n";
              }
              if ($this->validator) {
                $content .= '     public function validator(){'."\n";
                   $content .= "        //Code will go here"."\n";
                $content .= '     }'."\n";
                $content .= ''."\n";
              }
              if ($this->onConstruct) {
               $content .= '     public function onConstruct(){'."\n";
                 $content .= "        //Code will go here"."\n";
               $content .= '     }'."\n";
               $content .= ''."\n";
              }
              if ($this->afterSave) {
               $content .= '     public function afterSave(){'."\n";
                    $content .= "        //Code will go here"."\n";
               $content .= '     }'."\n";
               $content .= ''."\n";
              }

          $content .= '}'."\n";
  
          if (!file_exists($fullPath)) {
              try {
               $resp = file_put_contents($fullPath,$content);
              } catch (\Throwable $th) {
                   echo $th;
              }
          }else {
              return 'exists';
          }
          return true;
     }
}
