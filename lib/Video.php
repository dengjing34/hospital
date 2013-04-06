<?php
/**
 * Description of Video
 *
 * @author dengjing
 */
class Video extends Data {
    public $videoGUID, $optGUID, $videoTitle, $saveIP, $fileName, $filePath, $beginTM, $endTM, $fielSize, $playLen;

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
        $filePath = $this->filePath . $this->fileName;
        $realFile = is_file($filePath) ? Url::filePath($this->fileName) : Url::siteUrl(self::PLAYER_DEFAULT_VIDEO);
        $pic = $this->getPreview();
        $picPath = $pic->filePath . $pic->fileName;
        $preview = is_file($picPath) ? Url::filePath($pic->fileName) : Url::siteUrl(self::PLAYER_DEFAULT_PREVIEW);
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
}

?>
