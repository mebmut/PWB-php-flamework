<?php
// turns php error display from user on/off 
define('DEBUG',true);
// sets the site to run in developer mode 
define('PRODUCTION',true);
// defined diriectory separator for different oparatings systems 
define('DS',DIRECTORY_SEPARATOR);
// defined root falder for php file include functions 
define('ROOT', dirname(__FILE__).DS);
// defined path for routings and style/script includes
define('URLROOT','/pwb/');
// iclude site helper functions file 
include(ROOT.'core'.DS.'Functions.php');
//this is the autoload function to load required classes
function classLoader($className){
    $classAry = explode('\\',$className);
    $class = array_pop($classAry);
    $subPath = strtolower(implode(DS,$classAry));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if(file_exists($path)){
      require_once($path);
    }
}
// calls the autoload function 
spl_autoload_register('classLoader');
// start sessions 
session_start();
// starts the application and runs athetification checks 
run_application();
