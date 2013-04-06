<?php
//dengjing34@vip.qq.com
class Patient extends Data{
    public $patGUID, $optGUID, $patIDCardNum, $patName, $patAge, $patSex, $patCardNum, $patMedRecID;
    public $patBedNum, $patWard, $patMemo;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;
    public static $_sex = array(
        self::SEX_MALE => '男',
        self::SEX_FEMALE => '女',
    );

    function __construct() {
        $options = array(
            'key' => 'patGUID',
            'table' => 'hlpatrecord',
            'columns' => array(
                'patGUID' => 'PatGUID',
                'optGUID' => 'OptGUID',
                'patIDCardNum' => 'PatIDCardNum',
                'patName' => 'PatName',
                'patAge' => 'PatAge',
                'patSex' => 'PatSex',
                'patCardNum' => 'PatCardNum',
                'patMedRecID' => 'PatMedRecID',
                'patBedNum' => 'PatBedNum',
                'patWard' => 'PatWard',
                'patMemo' => 'PatMemo',
            ),
            'saveNeeds' => array(),
        );
        parent::init($options);
    }

    public function getSex() {
        return isset(self::$_sex[$this->patSex]) ? self::$_sex[$this->patSex] : '未知';
    }
}

?>
