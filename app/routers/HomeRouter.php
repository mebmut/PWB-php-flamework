<?php
namespace App\Routers;

use Core\Router;

class HomeRouter extends Router
{

    public function index(){
        $this->view->page('index');
    }
}
