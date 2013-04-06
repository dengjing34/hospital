<?php
/**
 * Description of Dept
 *
 * @author dengjing
 */
class Dept extends Data{
    public $id, $name;
    const CACHE_PREFIX = 't_dept';
    const CACHE_KEY_GET_ALL_DEPT = '_get_all_dept';
    public static $formFields = array(
        'name' => array(
            'text' => '部门名称', 'required' => true, 'hint' => '请填写部门名称', 'size' => '30', 'tip' => '部门名称不能为空哦'
        ),
    );

    function __construct() {
        $options = array(
            'key' => 'id',
            'table' => 't_dept',
            'columns' => array(
                'id' => 'id',
                'name' => 'name',
            ),
            'saveNeeds' => array(),
        );
        parent::init($options);
    }

    public static function getAllDept() {
        $cacheId = self::genCacheKey(self::CACHE_PREFIX, self::CACHE_KEY_GET_ALL_DEPT);
        $cacheLite = new Cache_Lite();
        $cacheLite->setLifeTime(60 * 60 * 24);
        if (($result = $cacheLite->get($cacheId, self::CACHE_PREFIX)) === false) {
            $o = new self();
            $result = array();
            /*@var $oo Dept*/
            foreach ($o->find() as $oo) {
                $result[$oo->id] = $oo;
            }
            $cacheLite->save($result, $cacheId, self::CACHE_PREFIX);
        }
        return $result;
    }

    public static function getDeptOptions() {
        $result = array();
        /*@var $eachDept Dept*/
        foreach (self::getAllDept() as $eachDept) {
            $result[$eachDept->id] = $eachDept->name;
        }
        return $result;
    }

    public function clearAllDeptCache() {
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
        $this->clearAllDeptCache();
        return $this;
    }

    public function delete($value = null) {
        try {
            parent::delete($value);
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
        $this->clearAllDeptCache();
        return $this;
    }
}

?>
