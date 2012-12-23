<?php
//dengjing34@vip.qq.com
class Patient extends Data{
    public $id, $name, $age, $sex, $cardNum, $ward, $bedNum, $memo, $attributeData;
    
    function __construct() {
        $options = array(
            'key' => 'id',
            'table' => 'hlPatInfo',
            'columns' => array(
                'id' => 'id',
                'name' => 'PatName',
                'age' => 'PatAge',
                'sex' => 'PatSex',
                'cardNum' => 'PatCardNum',
                'ward' => 'PatWard',
                'bedNum' => 'PatBedNum',
                'memo' => 'PatMemo',
                'attributeData' => 'attributeData',
            ),
            'saveNeeds' => array(
                'name',
                'age',
                'sex',
                'cardNum',
                'ward',
                'bedNum',                
            )
        );
        parent::init($options);
    }
}

?>
