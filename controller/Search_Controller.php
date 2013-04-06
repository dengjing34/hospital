<?php
/**
 * Description of Search_Controller
 *
 * @author dengjing
 */
class Search_Controller extends Controller{
    function  __construct() {
        parent::__construct();
        $this->validateLogin();
    }

    public function doctor() {
        $o = new Users();
        $where = array();
        $alias = $this->url->get('alias');
        if (strlen($alias) > 0) {
            $where[] = array('alias', "like '%{$alias}%'");
        }
        Pager::$pageSize = 12;
        $total = $o->count(array(
            'whereAnd' => $where,
        ));
        $page = Pager::requestPage($total);
        $limit = Pager::limit($page);
        $users = $o->find(array(
            'limit' => $limit,
            'whereAnd' => $where,
        ));
        $pager = Pager::showPage($total);
        $view = new View('search/doctor', compact('users', 'pager', 'alias'));
        $this->render($view->render());
    }

    public function patient() {
        $o = new Patient();
        $where = array();
        $patName = $this->url->get('patName');
        if (strlen($patName) > 0) {
            $where[] = array('patName', "like '%{$patName}%'");
        }
        Pager::$pageSize = 10;
        $total = $o->count(array(
            'whereAnd' => $where,
        ));
        $page = Pager::requestPage($total);
        $limit = Pager::limit($page);
        $patients = $o->find(array(
            'limit' => $limit,
            'whereAnd' => $where,
        ));
        $operationIds = array_map(function($pat) {
            return $pat->optGUID;
        }, $patients);
        $operation = new Operations();
        $operations = $operation->loads(array_flip($operationIds));
        $pager = Pager::showPage($total);
        $view = new View('search/patient', compact('patients', 'patName', 'pager', 'operations'));
        $this->render($view->render());
    }

    public function operation() {
        $o = new Operations();
        $where = array();
        $optName = $this->url->get('optName');
        if (strlen($optName) > 0) {
            $where[] = array('optName', "like '%{$optName}%'");
        }
        Pager::$pageSize = 10;
        $total = $o->count(array(
            'whereAnd' => $where,
        ));
        $page = Pager::requestPage($total);
        $limit = Pager::limit($page);
        $operations = $o->find(array(
            'limit' => $limit,
            'whereAnd' => $where,
        ));
        $pager = Pager::showPage($total);
        $view = new View('search/operation', compact('operations', 'pager', 'optName'));
        $this->render($view->render());
    }

    public function time() {
        $o = new Operations();
        $where = array();
        $optDateStart = $this->url->get('optDateStart');
        $optDateEnd = $this->url->get('optDateEnd');
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $optDateStart) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $optDateEnd)) {
            $where[] = array('optDate', ">= '{$optDateStart} 00:00:00'");
            $where[] = array('optDate', "<= '{$optDateEnd} 23:59:59'");
        }
        Pager::$pageSize = 10;
        $total = $o->count(array(
            'whereAnd' => $where,
        ));
        $page = Pager::requestPage($total);
        $limit = Pager::limit($page);
        $operations = $o->find(array(
            'limit' => $limit,
            'whereAnd' => $where,
        ));
        $pager = Pager::showPage($total);
        $view = new View('search/time', compact('operations', 'pager', 'optDateStart','optDateEnd'));
        $this->render($view->render());
    }

    public function keyword() {
        $o = new Operations();
        $fields = array(
            'optDocName',
            'optMazuishi',
            'optAssDocName',
            'optNurseName',
            'optZDName',
            'optName',
            'optMazuiName',
        );
        $q = $this->url->get('q');
        $where = $options = array();
        if (strlen($q) > 0) {
            foreach ($fields as $field) {
                $where[] = "`{$o->columns[$field]}` LIKE '%{$q}%'";
            }
            $options['where'] = implode(' OR ', $where);
        }
        Pager::$pageSize = 10;
        $total = $o->count($options);
        $page = Pager::requestPage($total);
        $limit = Pager::limit($page);
        $options['limit'] = $limit;
        $operations = $o->find($options);
        $pager = Pager::showPage($total);
        $view = new View('search/keyword', compact('operations', 'pager', 'q'));
        $this->render($view->render());
    }
}

?>
