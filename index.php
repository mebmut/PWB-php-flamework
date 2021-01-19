<?php
define('DEBUG',true);
define('PRODUCTION',true);
define('DS',DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__).DS);
define('URLROOT','/pezani/');
include(ROOT.'core'.DS.'Functions.php');
function classLoader($className){
    $classAry = explode('\\',$className);
    $class = array_pop($classAry);
    $subPath = strtolower(implode(DS,$classAry));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if(file_exists($path)){
      require_once($path);
    }
}
spl_autoload_register('classLoader');
session_start();
run_application();
