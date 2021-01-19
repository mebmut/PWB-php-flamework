<?php
namespace App\Routers;
use Core\{Session,Router};
use App\Queries\{SetAdmin,SetDatabase,GenMigration,GenModel};

class AppRouter extends Router{

    public function onConstruct(){
        $this->view->setLayout("settings");
    }

    public function admin(){
        $model = new SetAdmin;
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $model->assign($this->request->get());
            $model->validator();
            if($model->validationPassed()){
                if ($model->save()) {
                    Session::addMsg('success','Site admin has been set');
                    Router::redirect('home');
                }
            }
        }
        $this->view->errors = $model->getErrorMessages();
        $this->view->user = $model;
        $this->view->settings('admin');
    }

    public function database(){
        $model = new SetDatabase;
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $model->assign($this->request->get());
            $model->validator();
            if($model->validationPassed()){
                if ($model->save()) {
                    Session::addMsg('success','Database info has been saved');
                    Router::redirect('home');
                }
            }
        }
        $this->view->errors = $model->getErrorMessages();
        $this->view->db = $model;
        $this->view->settings('database');
    }

    public function gen_model(){
        $model = new GenModel;
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $model->assign($this->request->get());
            $model->validator();
            if ($model->validationPassed()) {
               if ($model->save()) {
                   Session::addMsg('success','Model has been created');
                   Router::redirect('app/gen_model/md5/cript/ltp/');
               }
            }
        }
        $this->view->errors = $model->getErrorMessages();
        $this->view->model = $model;
        $this->view->settings('gen_model');
    }

    public function migrations(){
        $model = new GenMigration;
        if ($this->request->isSet('gen')) {
            $this->request->csrfCheck();
            $model->assign($this->request->get());
            $model->validator();
            if($model->validationPassed()){
                if ($model->save()) {
                    Session::addMsg('success','migration file created');
                    Router::redirect('app/migrations/gen/auto/tlp_332');
                }
            }
        }

        if ($this->request->isSet('run')) {
            if ($masage = $model->run()) {
                Session::addMsg('success',$masage);
                Router::redirect('app/migrations/run/md5/tlp_pos/876');
            }
        }

        $this->view->errors = $model->getErrorMessages();
        $this->view->migration = $model;
        $this->view->settings('migrations');
    }
}
