<?php
namespace App\Queries;

use Core\{Model,Cookie,Session,Validation};
use App\Queries\UserSessions;

class Users extends Model {
  protected static $_table='users', $_softDelete = true;
  public static $currentLoggedInUser = null;
  public $id,$username,$email,$password,$fname,$lname,$acl,$deleted = 0,$confirm;
  public $cover='',$thumbnail='',$bio='';
  const blackListedFormKeys = ['id','deleted'];

  public function validator(){
    $this->runValidation(new Validation($this,'required','fname@first name'));
    $this->runValidation(new Validation($this,'required','lname@last name'));
    $this->runValidation(new Validation($this,'required','username'));
    $this->runValidation(new Validation($this,'required','email'));
    $this->runValidation(new Validation($this,'required','password'));
    $this->runValidation(new Validation($this,'required','confirm@confirm password'));
    $this->runValidation(new Validation($this,'equal','password@confirm password','confirm'));
    $this->runValidation(new Validation($this,'min','fname@first name',3));
    $this->runValidation(new Validation($this,'min','lname@last name',3));
    $this->runValidation(new Validation($this,'min','username',3));
    $this->runValidation(new Validation($this,'min','password',6));
    $this->runValidation(new Validation($this,'email','email'));
    $this->runValidation(new Validation($this,'unique','email'));
    $this->runValidation(new Validation($this,'unique','username'));
  }

  public function beforeSave(){
    $this->timeStamps();
    if($this->isNew()){
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }
  }

  public static function findByUsername($username) {
    return self::findFirst(['conditions'=> "username = ?", 'bind'=>[$username]]);
  }

  public static function getUserImage($id) {
    if (is_int($id)) {
      $userImage = self::findById($id)->thumbnail;
    }else{
      $userImage = self::findFirst($id)->thumbnail;
    }
    return (isset($userImage)&&!empty($userImage)) ? $userImage : getTempImage() ;
  }

  public static function getUserName($id) {
    if (is_numeric($id)) {
      $username = self::findById($id);
    }elseif(is_string($id)){
      $username = self::findFirst($id);
    }
    if (isset($username)&&$username!=null) {
      return $username->username;
    }
  }

  public static function currentUser() {
    if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
      self::$currentLoggedInUser = self::findById((int)Session::get(CURRENT_USER_SESSION_NAME));
    }
    return self::$currentLoggedInUser;
  }

  public function login($rememberMe=false) {
    Session::set(CURRENT_USER_SESSION_NAME, $this->id);
    if (isAdmin()) {
      Session::set(ADMIN_USER_SESSION,$this->id);
    }
    if($rememberMe) {
      $hash = md5(uniqid() + rand(0, 100));
      $user_agent = Session::uagent_no_version();
      Cookie::set(REMEMBER_ME_COOKIE_NAME, $hash, REMEMBER_ME_COOKIE_EXPIRY);
      $fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
      self::$_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
      $us = new UserSessions();
      $us->assign($fields);
      $us->save();
      // self::$_db->insert('user_sessions', $fields);
    }
  }

  public static function loginUserFromCookie() {
    $userSession = UserSessions::getFromCookie();
    if($userSession && $userSession->user_id != '') {
      $user = self::findById((int)$userSession->user_id);
      if($user) {
        $user->login();
        Urls::redirect('');
      }
      return $user;
    }
    return;
  }

  public function logout() {
    $userSession = UserSessions::getFromCookie();
    if($userSession) $userSession->delete();
    Session::delete(CURRENT_USER_SESSION_NAME);
    if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
      Cookie::delete(REMEMBER_ME_COOKIE_NAME);
    }
    self::$currentLoggedInUser = null;
    return true;
  }

  public function acls() {
    if(empty($this->acl)) return [];
    return json_decode($this->acl, true);
  }

  public static function addAcl($user_id,$acl){
    $user = self::findById($user_id);
    if(!$user) return false;
    $acls = $user->acls();
    if(!in_array($acl,$acls)){
      $acls[] = $acl;
      $user->acl = json_encode($acls);
      $user->save();
    }
    return true;
  }

  public static function removeAcl($user_id, $acl){
    $user = self::findById($user_id);
    if(!$user) return false;
    $acls = $user->acls();
    if(in_array($acl,$acls)){
      $key = array_search($acl,$acls);
      unset($acls[$key]);
      $user->acl = json_encode($acls);
      $user->save();
    }
    return true;
  }
}
