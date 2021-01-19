<?php
use Core\Session;
use Core\Application;

function debug($data){
   echo '<pre>';
      var_dump($data);
   echo '</pre>';
    die();
}

function currentPage(){
    $currentPage = $_SERVER['REQUEST_URI'];
    $app =  new Application;
    if ($currentPage==PROOT||$currentPage==PROOT.$app->router().'/index') {
        $currentPage = PROOT.$app->router();
    }
    return $currentPage;
}

function run_application(){
   $init = new Application;
   $init->set_application();
   $init->initiate_application();
}

function getJsonFile($location=''){
   $file = ($location ?? '') ? file_get_contents($location) : false;
   if ($file) {
      return json_decode($file);
   }
}

function getError($name,$errors=[]){
   if ($errors) {
      if (array_key_exists($name,$errors)) {
         return '<p class="input-error">'.$errors[$name].'</p>';
       }
   }
}

/**
* Creates a hidden input to be used in a form for csrf
* @method csrfInput
* @return string    return html string for form input
*/
function csrfInput(){
   return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.Session::generateToken().'" /><br>';
}

/**
* Cleans user input with htmlentities
* @method sanitize
* @param  string   $dirty string of dirty user input
* @return string          string of cleaned user input
*/
function sanitize($dirty) {
   return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}
