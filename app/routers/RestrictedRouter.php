<?php

namespace App\Routers;

use Core\Router;

class RestrictedRouter extends Router
{
    public function index(){
        echo "This is the indexRoute of the home RestrictedRouter";
    }    
}
