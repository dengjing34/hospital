<?php
//dengjing34@vip.qq.com
class Fav extends Data {

    public $id, $userId, $operationId;

    function __construct() {
        $options = array(
            'key' => 'id',
            'table' => 't_fav',
            'columns' => array(
                'id' => 'id',
                'userId' => 'user_id',
                'operationId' => 'operation_id',
            ),
            'saveNeeds' => array(
            )
        );
        parent::init($options);
    }

}
?>
