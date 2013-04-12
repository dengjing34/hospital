<?php
/**
 * Description of Pic
 *
 * @author dengjing
 */
class Pic extends Data{
    public $picGUID, $videoGUID, $optGUID, $saveIP, $fileName, $filePath, $createTM, $fielSize;

    function __construct() {
        $options = array(
            'key' => 'picGUID',
            'table' => 'hlpicinfo',
            'columns' => array(
                'picGUID' => 'PicGUID',
                'videoGUID' => 'VideoGUID',
                'optGUID' => 'OptGUID',
                'saveIP' => 'SaveIP',
                'fileName' => 'FileName',
                'filePath' => 'FilePath',
                'createTM' => 'CreateTM',
                'fileSize' => 'FileSize',
            ),
            'saveNeeds' => array(),
        );
        parent::init($options);
    }

    /**
     * 获取视频预览图片的url地址
     * @return string
     */
    public function getPicUrl() {
        $picPath = $this->filePath . '/' . $this->fileName;
        return Url::videoUrl($picPath);
    }
}

?>
