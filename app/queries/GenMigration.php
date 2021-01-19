<?php
namespace App\Queries;

use Core\{Model,Validation};

class GenMigration extends Model {

     public $table;

     protected static $_table = 'migrations';

     public function validator(){
          $this->runValidation(new Validation($this,'required','table','required'));
     }

     public function save(){
            $fileName = "Migration".time();
            $ext = ".php";
            $table = $this->table;
            $fullPath = ROOT.'app'.DS.'migrations'.DS.$fileName.$ext;
            $content = '<?php'."\n";
            $content .= 'namespace App\Migrations;'."\n";
            $content .= ''."\n";
            $content .= 'use Core\Migration;'."\n";
            $content .= ''."\n";
            $content .= 'class '.$fileName.' extends Migration {'."\n";
                $content .= '     public function up() {'."\n";
                $content .= '        $table = \''.$table.'\';'."\n";
                $content .= '        $this->createTable($table);'."\n";
                $content .= '        $this->addTimeStamps($table);'."\n";
                $content .= '        $this->addSoftDelete($table);'."\n";
                $content .= '        $this->addIndex($table,\'created_at\');'."\n";
                $content .= '        $this->addIndex($table,\'updated_at\');'."\n";
            $content .= '     }'."\n";
            $content .= '}'."\n";
           if ( $resp = file_put_contents($fullPath,$content)) {
                return true;
           }
     }

     public function run(Type $var = null){
          $isCli = php_sapi_name() == 'cli';
          $migrationTable = self::getDb()->query("SHOW TABLES LIKE 'migrations'")->results();
          $previousMigs = [];
          $migrationsRun = [];

          if(!empty($migrationTable)){
            $query = self::getDb()->query("SELECT migration FROM migrations")->results();
            foreach($query as $q){
              $previousMigs[] = $q->migration;
            }
          }
          // get all files
          $migrations = glob('app'.DS.'migrations'.DS.'*.php');
          $resp = [];
          foreach($migrations as $fileName){
            $klass = str_replace('app'.DS.'migrations'.DS,'',$fileName);
            $klass = str_replace('.php','',$klass);
            if(!in_array($klass,$previousMigs)){
              $klassNamespace = 'App'.DS.'Migrations\\'.$klass;
              $mig = new $klassNamespace($isCli);
              $mig->up();
              self::getDb()->insert('migrations',['migration'=>$klass]);
              $migrationsRun[] = $klassNamespace;
            }
          }
          if(sizeof($migrationsRun) == 0){
            if($isCli){
              return "\e[0;37;42m\n\n"."    No new migrations to run.\n\e[0m\n";
            } else {
              return 'No new migrations to run.';
            }
          }else{
            return 'All Migrations were run successfully.';
          }
             
     }
}
