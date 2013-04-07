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
        $o = new Operations();
        $oo = $o->loads($operationIds);
        $pager = Pager::showPage($total);
        $view = new View('home/fav', compact('oo', 'pager'));
        $this->render($view->render());
    }

    function profile() {
        $o = new Users();
        $userLogic = new User_Logic();
        $userInfo = $userLogic->getUserCookie();
        $oo = new Operations();
        $oo->optDocName = $userInfo['alias'];
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
        $userLogic = new User_Logic();
        $userInfo = $userLogic->getUserCookie();
        $oo = new Operations();
        $oo->optDocName = $userInfo['alias'];
        Pager::$pageSize = 6;
        $oo->optDocName = $userInfo['alias'];
        $total = $oo->count();
        $page = Pager::requestPage($total);
        $offset = ($page - 1) * Pager::$pageSize;
        $operations = $oo->find(array(
            'limit' => "{$offset}, " . Pager::$pageSize,
        ));
        $pager = Pager::showPage($total);
        $view = new View('home/lib', compact('operations', 'pager'));
        $this->render($view->render());
    }

    function borrow() {
        $borrow = new Borrow();
        $userLogic = new User_Logic();
        $user = $userLogic->getUserCookie();
        $borrow->userId = $user['id'];
        Pager::$pageSize = 6;
        $total = $borrow->count();
        $page = Pager::requestPage($total);
        $operationIds = array();
        foreach ($borrow->find(array('limit' => Pager::limit($page))) as $val) {
            $operationIds[$val->operationId] = $val->operationId;
        }
        $o = new Operations();
        $oo = $o->loads($operationIds);
        $pager = Pager::showPage($total);
        $view = new View('home/fav', compact('oo', 'pager'));
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
        $oo = new Operations();
        $oo->optDocName = $o->alias;
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
        $userLogic = new User_Logic();
        $user = $userLogic->getUserCookie();
        $id = $this->url->get('id');
        $vid = $this->url->get('vid');
        if (!ctype_digit($id)) {
            $this->error('手术id不能为空哦');
        }
        $o = new Operations();
        $video = new Video();
        try {
            $o->load($id);
            $video->optGUID = $o->optGUID;
            $videos = $video->find();
            $currVideo = new Video();
            if (ctype_digit($vid)) {
                $currVideo->load($vid);
            } elseif (!empty($videos)) {
                $currVideo = current($videos);
            }
            $f = new Fav();
            $f->userId = $user['id'];
            $f->operationId = $id;
            $fav = $f->exists();
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $view = new View('home/view',  compact('o', 'videos', 'currVideo', 'user', 'fav'));
        $this->render($view->render());
    }
}
?>
