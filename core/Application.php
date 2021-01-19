<?php
namespace Core;
use \Exception;
use Core\Access;
class Application{
    
    private $view, $router = 'HomeRouter', $route = 'index',$router_name,$params;

    public function __construct(){
       $url = ($_SERVER['PATH_INFO'] ?? '') ? explode('/',trim($_SERVER['PATH_INFO'],'/')) : [];
       $this->router = ($url[0] ?? '') ? ucfirst($url[0]).'Router' : $this->router;
       $this->router_name = str_ireplace('Router','',$this->router);
       array_shift($url);
       $this->route = ($url[0] ?? '') ? strtolower($url[0]) : $this->route;
       array_shift($url);
       $this->params = $url;
       if (!Access::hasAccess($this->router_name,$this->route)) {
           $this->router = "RestrictedRouter";
       }
    }

    public function router(){
        return $this->router();
    }

    public function initiate_application(){
        if(DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
          } else {
            error_reporting(E_ALL);
            ini_set('display_errors', null);
            ini_set('log_errors', 1);
            ini_set('error_log', ROOT.'logs'.DS.'errors.log');
          }
          
        $router = 'App\Routers\\'.$this->router;
        try {
            $dispatch =  new $router($this->router,$this->route);
        } catch (\Throwable $e) {
            echo "Dispatch Exeption ".get_class().": ".$e->getMessage()."<br>";
        }
        if (method_exists($router,$this->route)) {
            call_user_func_array([$dispatch,$this->route],$this->params);
        }else{
            echo "The route \"$this->route\" does not exist in this application";
        }
    }

    public function set_application(Type $var = null){
        if (!file_exists(ROOT.'app'.DS.'settings'.DS.'admin.json')) {
            $this->router = 'AppRouter';
            $this->route = 'admin';
           }elseif (!file_exists(ROOT.'app'.DS.'settings'.DS.'database.json')) {
               $this->router = 'AppRouter';
               $this->route = 'database';
           }
    }
}
