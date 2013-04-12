<?php
/**
 * Description of Video
 *
 * @author dengjing
 */
class Video extends Data {
    public $videoGUID, $optGUID, $videoTitle, $saveIP, $fileName, $filePath, $beginTM, $endTM, $fileSize, $playLen;

    const PLAYER_WIDTH = 545;
    const PLAYER_HEIGHT = 410;
    const PLAYER_DEFAULT_VIDEO = 'images/GoogleImaginaryForces.mp4';
    const PLAYER_DEFAULT_PREVIEW = 'images/Preview.jpg';
    const PLAYER_WRAPPER = 'player-wrapper';
    function __construct() {
        $options = array(
            'key' => 'videoGUID',
            'table' => 'hlrecvideo',
            'columns' => array(
                'videoGUID' => 'VideoGUID',
                'optGUID' => 'OptGUID',
                'videoTitle' => 'VideoTitle',
                'saveIP' => 'SaveIP',
                'fileName' => 'FileName',
                'filePath' => 'FilePath',
                'beginTM' => 'BeginTM',
                'endTM' => 'EndTM',
                'fileSize' => 'FileSize',
                'playLen' => 'PlayLen',
            ),
            'saveNeeds' => array(),
        );
        parent::init($options);
    }

    /**
     * 获取播放器脚本
     * @param string $container 播放器容器id 默认player-wrapper
     * @param int $width 播放器宽度 默认454
     * @param int $height 播放器高度 默认 410
     * @return string 生成播放器的js脚本
     */
    public function playerScript($container = self::PLAYER_WRAPPER, $width = self::PLAYER_WIDTH, $height = self::PLAYER_HEIGHT) {
        $swfobject = Url::siteUrl('js/swfobject.js');
        $playswf = '/images/player.swf';
        $realFile = $this->getVideoUrl();
        $pic = $this->getPreview();
        $preview = $pic->getPicUrl();
        $html = <<<EOT
<script type='text/javascript' src='{$swfobject}'></script>
<script type='text/javascript'>
    var so = new SWFObject('{$playswf}','ply','{$width}','{$height}','9','#ffffff');
    so.addParam('allowfullscreen','true');
    so.addParam('allowscriptaccess','always');
    so.addParam('wmode','opaque');
    so.addVariable('file','{$realFile}');
    so.addVariable('image','{$preview}');
    so.addVariable('logo','');
    so.write('{$container}');
</script>
EOT;
        return $html;
    }

    /**
     * 获取视频预览图
     * @return Pic
     */
    public function getPreview() {
        $o = new Pic();
        $o->videoGUID = $this->videoGUID;
        $result = $o->find(array('limit' => 1));
        return !empty($result) ? current($result) : $o;
    }

    public function getFileSize() {
        return ceil((int)$this->fileSize / (1024 * 1024)) . 'M';
    }

    public function getBeginTM() {
        return date('Y-m-d H:i:s', $this->beginTM);
    }

    public function getEndTM() {
        return date('Y-m-d H:i:s', $this->endTM);
    }

    public function getPlayLen() {
        if ($this->playLen < 60) {
            return $this->playLen . '秒';
        } elseif ($this->playLen < 3600) {
            return floor($this->playLen / 60) . '分' . ($this->playLen % 60) . '秒';
        } else {
            $h = floor($this->playLen / 3600);
            $m = floor(($this->playLen - $h * 3600) / 60);
            $s = $this->playLen - $h * 3600 - $m * 60;
            return "{$h}时{$m}分{$s}秒";
        }
    }

    public function getVideoUrl() {
        $filePath = $this->filePath . '/' . $this->fileName;
        return Url::videoUrl($filePath);
    }

    /**
     *
     * @param type $value
     * @return \Video
     */
    public function delete($value = null) {
        $key = $this->key;
        if (!is_null($value)) {
            $this->{$key} = $value;
        }
        if (!is_null($this->{$key})) {
            $pic = new Pic();
            $pic->videoGUID = $this->{$key};
            /*@var $eachPic Pic*/
            foreach ($pic->find() as $eachPic) {
                $eachPic->delete($eachPic->picGUID);
            }
            parent::delete($value);
        }
        return $this;
    }
}

?>
