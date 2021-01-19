<?php
namespace App\Routers;
use App\Queries\Login;
use App\Queries\Users;
use Core\Router;


class AuthRouter extends Router {

  public function login() {
    $login = new Login();
    if($this->request->isPost()) {
      // form validation
      $this->request->csrfCheck();
      $login->assign($this->request->get());
      $login->validator();
      if($login->validationPassed()){
        $user = Users::findByUsername($_POST['username']);
        if($user && password_verify($this->request->get('password'), $user->password)) {
          $remember = $login->getRememberMeChecked();
          $user->login($remember);
          Router::redirect('');
        }  else {
          $login->addErrorMessage('username','There is an error with your username or password');
        }
      }
    }
    $this->view->login = $login;
    $this->view->displayErrors = $login->getErrorMessages();
    $this->view->page('auth/login');
  }

  public function logout() {
    if(Users::currentUser()) {
      Users::currentUser()->logout();
    }
    Router::redirect('home');
  }

  public function register() {
    $newUser = new Users();
    if($this->request->isPost()) {
      $this->request->csrfCheck();
      $newUser->assign($this->request->get(),Users::blackListedFormKeys);
      $newUser->confirm =$this->request->get('confirm');
      if($newUser->save()){
        Router::redirect('auth/login');
      }
    }
    $this->view->newUser = $newUser;
    $this->view->displayErrors = $newUser->getErrorMessages();
    $this->view->page('auth/register');
  }
}
