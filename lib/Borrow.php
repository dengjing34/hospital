<?php
//dengjing34@vip.qq.com
class Borrow extends Data {

    public $id, $userId, $operationId;

    function __construct() {
        $options = array(
            'key' => 'id',
            'table' => 't_borrow',
            'columns' => array(
                'id' => 'id',
                'userId' => 'user_id',
                'operationId' => 'operation_id',
            ),
            'saveNeeds' => array(
                'userId',
                'operationId',
            )
        );
        parent::init($options);
    }

}
?>
