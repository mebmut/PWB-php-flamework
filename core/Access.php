<?php
namespace Core;
use Core\Session;
class Access{

	public static function getAccess(){
		if (Session::exists('user')) {
			return "User";
		}elseif (PRODUCTION) {
			return "Admin";
		}else{
			return 'Guest';
		}

	}

	public static function hasAccess($router,$route){
		$access = false;
		if (file_exists(ROOT.'app'.DS.'settings'.DS.'access.json')) {
			$acls = getJsonFile(ROOT.'app'.DS.'settings'.DS.'access.json');
			foreach ($acls as $key => $value) {
				if ($key==$router) {
					$access = self::setAccess($value,$route,$router);
				}
			}
		}
		return $access;
	}
	public static function setAccess($acls,$route,$router){
		$denied = [];
		$allowed = [];
		$access = false;
		foreach ($acls as $key => $val) {
			if (self::getAccess()==$key) {
				$denied = $val->denied;
				$allowed = $val->allowed;
			}
		}
		if (in_array('*', $allowed)&&!in_array($route, $denied)) {
			$access = true;
		}elseif (in_array('*', $allowed)&&in_array($route, $denied)) {
			$access = false;
		}elseif (in_array('*', $denied)&&!in_array($route, $allowed)) {
			$access = false;
		}elseif (in_array('*', $denied)&&in_array($route, $allowed)) {
			$access = true;
		}elseif (in_array('*', $denied)&&in_array('*', $allowed)) {
			$access = true;
		}
		return $access;
	}
}