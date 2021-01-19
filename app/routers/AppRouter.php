<?php
namespace App\Routers;
use Core\{Session,Router};
use App\Queries\{SetAdmin,SetDatabase,GenMigration};

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
                    Router::redirect('home');
                }
            }
        }
        $this->view->errors = $model->getErrorMessages();
        $this->view->user = $model;
        $this->view->settings('settings/admin');
    }

    public function database(){
        $model = new SetDatabase;
        if($this->request->isPost()) {
            $this->request->csrfCheck();
            $model->assign($this->request->get());
            $model->validator();
            if($model->validationPassed()){
                if ($model->save()) {
                    Router::redirect('home');
                }
            }
        }
        $this->view->errors = $model->getErrorMessages();
        $this->view->db = $model;
        $this->view->settings('settings/database');
    }

    public function gen_model(string $model=''){
        if (!empty($model)) {
            $ext = ".php";
            $fullPath = ROOT.'app'.DS.'queries'.DS.ucfirst($model).$ext;
            $content = '<?php'."\n";
            $content .= 'namespace App\Queries;'."\n";
            $content .= ''."\n";
            $content .= 'use Core\{Model,Validation};'."\n";
            $content .= ''."\n";
            $content .= 'class '.ucfirst($model).' extends Model {'."\n";
                $content .= ''."\n";
                $content .= '     protected static $_table = \'tmp_fake\';'."\n";
                $content .= ''."\n";
                $content .= '     public function validator(){'."\n";
                $content .= ''."\n";
                $content .= '     }'."\n";
            $content .= '}'."\n";
    
            if (!file_exists($fullPath)) {
                $resp = file_put_contents($fullPath,$content);
            }else {
                echo "Model $model already exists";
            }
        }else{
            echo "input the model name in the url eg /gen_model/users";
        }
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
        $this->view->settings('settings/migrations');
    }
}
