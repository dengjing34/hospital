<?php
//dengjing34@vip.qq.com
class Operation extends Data{
    public $id, $mainDoctor, $mazuishi, $assDoctor, $nurse, $zhenduan, $date, $name, $mazuifangshi, $attributeData;

    function __construct() {
        $options = array(
            'key' => 'id',
            'table' => 'hlOptInfo',
            'columns' => array(
                'id' => 'id',
                'mainDoctor' => 'OptMainDoctor',
                'mazuishi' => 'OptMazuishi',
                'assDoctor' => 'OptAssDoctor',
                'zhenduan' => 'OptZhenduan',
                'date' => 'OptDate',
                'name' => 'OptName',
                'mazuifangshi' => 'OptMazuiFangshi',
                'attributeData' => 'attributeData',
            ),
            'saveNeeds' => array(
                'mainDoctor',
                'mazuishi',
                'assDoctor',
                'zhenduan',
                'date',
                'name',
                'mazuifangshi'
            )
        );
        parent::init($options);
    }

    public function getDate($format = 'Y年n月j日') {
        return date($format, strtotime($this->date));
    }
}

?>
