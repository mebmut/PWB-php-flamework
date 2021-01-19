<?php
namespace Core;
use Core\Access;
class Navigation 
{
    public static function getList($list=''){
        $navString = '';
        $jsonFile = ($list ?? '') ? $list : 'user_nav';
        if ($navObjs = getJsonFile(ROOT.'app'.DS.'views'.DS.'header'.DS.$jsonFile.'.json')) {
            $navString .= '<ul class="nav-menu">'."\n";
            foreach ($navObjs as $router => $path) {
                if (is_object($path)) {
                    $navString .= ' <li class="nav-dropdown">';
                    $navString .= '<a class="dropdown-btn" data-target="'.$router.'-dropdown">'.$router.'</a>'."\n";
                    $navString .= '     <ul class="dropdown-items" id="'.$router.'-dropdown">'."\n";
                    foreach ($path as $name => $link) {
                        if (self::get_link($link)) {
                            $navString .= '        <li class="dropdown-item"><a href="'.URLROOT.$link.'">'.$name.'</a></li>'."\n";
                         }
                    }
                    $navString .= '     </ul>'."\n";
                    $navString .= ' </li>'."\n";
                }else{
                   if (self::get_link($path)) {
                      $navString .= '<li class="menu-item"><a href="'.URLROOT.$path.'">'.$router.'</a></li>';
                   }
                }
            }
            $navString .= '</ul>'."\n";
        }
        echo $navString;
        return $navString;
    }
    public static function get_link($val) {
        //check if external link
        if(preg_match('/https?:\/\//', $val) == 1) {
          return $val;
        } else {
          $uAry = explode('/', $val);
          $router = ucwords($uAry[0]);
          $route = (isset($uAry[1]))? $uAry[1] : '';
          if(Access::hasAccess($router, $route)) {
            return URLROOT . $val;
          }
          return false;
        }
      }
}
