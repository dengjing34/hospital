<?php
/**
 * Description of Dept_Controller
 *
 * @author dengjing
 */
class Dept_Controller extends Chibi_Controller{

    function  __construct() {
        parent::__construct();
    }

    public function deptList() {
        $o = new Dept();
        if (($ids = $this->url->post('id'))) {
            foreach ($ids as $id) {
                try {$o->delete($id);} catch (Exception $e) {$this->_error($e->getMessage());return;}
            }
            $this->_success(Url::getRefer());return;
        }
        $where = array();
        try {
            $total = $o->count(array('whereAnd' => $where));
        } catch (Exception $e) {
            $this->_error($e->getMessage());return;
        }
        $page = Pager::requestPage($total);
        $limit = ($page - 1) * Pager::$pageSize . "," . Pager::$pageSize;
        $objs = $o->find(
            array(
                'whereAnd' => $where,
                'limit' => $limit,
            )
        );
        $pager = Pager::showPage($total);
        $controller = $this->controllerName;
        $view = new View('chibi/dept/deptList', compact('objs', 'controller', 'pager'));
        $this->render($view->render());
    }

    public function deptAdd() {
        $o = new Dept();
        $form = new Form(Dept::$formFields);
        if ($this->url->post('submit')) {
            $validateResult = $form->validatePost();
            if($validateResult['error']) {
                $this->_error($validateResult['error']);return;
            }
            foreach ($validateResult['fields'] as $k => $v) $o->set($k, $v);
            try {
                $o->save();
                $this->_success(Url::siteUrl("chibi/{$this->controllerName}/{$this->controllerName}List"), '操作成功');return;
            } catch (Exception $e) {
                $this->_error($e->getMessage());return;
            }
        }
        $scripts = new View('chibi/components/sValidation');
        $view =  new View('chibi/components/tmpAdd', compact('scripts', 'form'));
        $this->render($view->render());
    }

    public function deptModify() {
        $id = $this->url->get('id');
        $o = new Dept();
        try {
            $o->load($id);
        } catch (Exception $e) {
            $this->_error($e->getMessage());return;
        }
        $form = new Form(Dept::$formFields);
        $form->assign($o);
        if ($this->url->post('submit')) {
            $validateResult = $form->validatePost();
            if($validateResult['error']) {
                $this->_error($validateResult['error']);return;
            }
            foreach ($validateResult['fields'] as $k => $v) $o->set($k, $v);
            try {
                $o->save();
                $this->_success($this->url->post('refer'));return;
            } catch (Exception $e) {
                $this->_error($e->getMessage());return;
            }
        }
        $scripts = new View('chibi/components/sValidation');
        $view =  new View('chibi/components/tmpModify');
        $view->scripts = $scripts->render();
        $view->form = $form;
        $view->refer = Url::getRefer() ? Url::getRefer() : Url::siteUrl("chibi/{$this->controllerName}/{$this->controllerName}List") ;
        $this->render($view->render());
    }
}

?>
