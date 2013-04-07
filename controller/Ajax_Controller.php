<?php
//dengjing34@vip.qq.com
class Ajax_Controller extends Controller{

    function __construct() {
        $this->noCache();
        parent::__construct();
    }

    private function output($msg) {
        if (is_array($msg)) {
            echo json_encode($msg);
        } else {
            echo $msg;
        }
    }

    public function index() {
        $this->fork();
    }

    public function favAdd() {
        $json = array();
        $userId = $this->url->get('userId');
        $operationId = $this->url->get('operationId');
        try {
            Fav::addFave($userId, $operationId);
            $json['status'] = 'success';
        } catch (Exception $e) {
            $json['msg'] = $e->getMessage();
            $json['status'] = 'fail';
        }
        $this->output($json);
    }

    public function favCancel() {
        $json = array();
        $userId = $this->url->get('userId');
        $operationId = $this->url->get('operationId');
        try {
            Fav::cancelFav($userId, $operationId);
            $json['status'] = 'success';
        } catch (Exception $e) {
            $json['msg'] = $e->getMessage();
            $json['status'] = 'fail';
        }
        $this->output($json);
    }
}

?>
