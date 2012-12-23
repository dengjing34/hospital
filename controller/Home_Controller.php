<?php
//dengjing34@vip.qq.com
class Home_Controller extends Controller{
    function  __construct() {
        $this->noCache();        
        parent::__construct();
        $this->validateLogin();
    }
    
    function index() {
        if ((bool)($userName = $this->url->post('userName')) && (bool)($password = $this->url->post('password'))) {
            $userLogic = new User_Logic();
            try {
                if ($userLogic->login($userName, $password)) {
                    Url::redirect(Url::getRefer());
                }
            } catch (Exception $e) {
                $this->error('登录失败', $e->getMessage());
            }            
        }
        $o = new Users();
        Pager::$pageSize = 12;
        $total = $o->count();
        $page = Pager::requestPage($total);
        $limit = Pager::limit($page);
        $users = $o->find(array(
            'limit' => $limit,
        ));
        $pager = Pager::showPage($total);
        $view = new View('home/welcome', compact('users', 'pager'));
        $this->render($view->render());
    }
    
    function fav() {
        $fav = new Fav();
        $userLogic = new User_Logic();
        $user = $userLogic->getUserCookie();
        $fav->userId = $user['id'];
        Pager::$pageSize = 6;
        $total = $fav->count();
        $page = Pager::requestPage($total);
        $operationIds = array();        
        foreach ($fav->find(array('limit' => Pager::limit($page))) as $val) {
            $operationIds[$val->operationId] = $val->operationId;
        }
        $o = new Operation();
        $oo = $o->loads($operationIds);
        $pager = Pager::showPage($total);
        $view = new View('home/fav', compact('oo', 'pager'));
        $this->render($view->render());  
    }
    
    function profile() {
        $o = new Users();
        $userLogic = new User_Logic();
        $userInfo = $userLogic->getUserCookie();
        $oo = new Operation();
        $oo->mainDoctor = $userInfo['alias'];
        $operations = $oo->find(array('limit' => '3'));
        try {
            $o->load($userInfo['id']);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }        
        $view = new View('home/doctor', compact('o', 'operations'));
        $this->render($view->render());
    }
    
    function lib() {
        $view = new View('home/lib');
        $this->render($view->render());
    }
    
    function borrow() {
        $view = new View('home/borrow');
        $this->render($view->render());
    }
    
    function search() {                
        $this->render(__FUNCTION__);
    }
    
    function doctor() {
        $id = $this->url->get('id');
        if (!ctype_digit($id)) $this->error("id:{$id} is not a numeric");
        $o = new Users();
        try {
            $o->load($id);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $oo = new Operation();
        $oo->mainDoctor = $o->alias;
        $operations = $oo->find(array('limit' => '3'));        
        $view = new View('home/doctor', compact('o', 'operations'));
        $this->render($view->render());
    }
    
    function quit() {
        $userLogic = new User_Logic();
        $userLogic->quit();
        Url::redirect(Url::siteUrl());
    }
    
    function view() {
        $this->render(__FUNCTION__);
    }
}
?>
