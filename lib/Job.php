<?php
/**
 * Description of Job
 *
 * @author dengjing
 */
class Job extends Data{
    public $id, $name;
    const CACHE_PREFIX = 't_job';
    const CACHE_KEY_GET_ALL_DEPT = '_get_all_job';
    public static $formFields = array(
        'name' => array(
            'text' => '职称名字', 'required' => true, 'hint' => '请填写职称名称', 'size' => '30', 'tip' => '职称名称不能为空哦'
        ),
    );

    function __construct() {
        $options = array(
            'key' => 'id',
            'table' => 't_job',
            'columns' => array(
                'id' => 'id',
                'name' => 'name',
            ),
            'saveNeeds' => array(),
        );
        parent::init($options);
    }

    public static function getAllJob() {
        $cacheId = self::genCacheKey(self::CACHE_PREFIX, self::CACHE_KEY_GET_ALL_DEPT);
        $cacheLite = new Cache_Lite();
        $cacheLite->setLifeTime(60 * 60 * 24);
        if (($result = $cacheLite->get($cacheId, self::CACHE_PREFIX)) === false) {
            $o = new self();
            $result = array();
            /*@var $oo Job*/
            foreach ($o->find() as $oo) {
                $result[$oo->id] = $oo;
            }
            $cacheLite->save($result, $cacheId, self::CACHE_PREFIX);
        }
        return $result;
    }

    public static function getJobOptions() {
        $result = array();
        /*@var $eachJob Job*/
        foreach (self::getAllJob() as $eachJob) {
            $result[$eachJob->id] = $eachJob->name;
        }
        return $result;
    }

    public function clearAllJobCache() {
        $cacheId = self::genCacheKey(self::CACHE_PREFIX, self::CACHE_KEY_GET_ALL_DEPT);
        $cache = new Cache_Lite();
        $cache->remove($cacheId, self::CACHE_PREFIX);
        return $this;
    }

    public function save() {
        try {
            parent::save();
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
        $this->clearAllJobCache();
        return $this;
    }

    public function delete($value = null) {
        try {
            parent::delete($value);
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
        $this->clearAllJobCache();
        return $this;
    }
}

?>
