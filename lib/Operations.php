<?php
/**
 * Description of Operations
 *
 * @author dengjing
 */
class Operations extends Data{
    public $optGUID, $optDocName, $optDocWorkID, $optMazuishi, $optMazuishiID, $optAssDocName, $optAssDocWorkID;
    public $optNurseName, $optNurseWorkID, $optZDName, $optZDWordID, $optDate, $optName, $optMazuiName, $optMazuiIndex;
    function __construct() {
        $options = array(
            'key' => 'optGUID',
            'table' => 'hloptrecord',
            'columns' => array(
                'optGUID' => 'OptGUID',
                'optDocName' => 'OptDocName',
                'optDocWorkID' => 'OptDocWorkID',
                'optMazuishi' => 'OptMazuishi',
                'optMazuishiID' => 'OptMazuishiID',
                'optAssDocName' => 'OptAssDocName',
                'optAssDocWorkID' => 'OptAssDocWorkID',
                'optNurseName' => 'OptNurseName',
                'optNurseWorkID' => 'OptNurseWorkID',
                'optZDName' => 'OptZDName',
                'optZDWordID' => 'OptZDWordID',
                'optDate' => 'OptDate',
                'optName' => 'OptName',
                'optMazuiName' => 'OptMazuiName',
                'optMazuiIndex' => 'OptMazuiIndex',
            ),
            'saveNeeds' => array(),
        );
        parent::init($options);
    }

    public function getDate($format = 'Y年n月j日') {
        return date($format, strtotime($this->optDate));
    }

    /**
     *
     * @return Patient
     */
    public function getPatient() {
        $o = new Patient();
        $o->OptGUID = $this->optGUID;
        $result = current($o->find());
        return $result ? $result : $o;
    }
}

?>
