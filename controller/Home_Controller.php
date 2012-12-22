<?php
//dengjing34@vip.qq.com
class Home_Controller extends Controller{
    function  __construct() {
        $this->noCache();
        parent::__construct();
    }
    
    function index() {
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
        $this->render(__FUNCTION__);  
    }
    
    function profile() {
        $this->render(__FUNCTION__);
    }
    
    function lib() {
        $this->render(__FUNCTION__);
    }
    
    function borrow() {
        $this->render(__FUNCTION__);
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
        $view = new View('home/doctor', compact('o'));
        $this->render($view->render());
    }
}
?>
