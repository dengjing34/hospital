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
                'userId',
                'operationId',
            )
        );
        parent::init($options);
    }

    public function save() {
        if ($this->exists()) {
            throw new Exception('已经收藏该视频');
        }
        return parent::save();
    }

    /**
     * 用户添加视频收藏
     * @param int $userId 收藏用户的id
     * @param int $operationId 手术的GUID
     * @return Fav 收藏成功返回Fav对象
     * @throws Exception
     */
    public static function addFave($userId, $operationId) {
        if (ctype_digit((string)$userId) && ctype_digit((string)$operationId)) {
            $operation = new Operations();
            $operation->optGUID = $operationId;
            $borrow = new Borrow();
            $borrow->operationId = $operationId;
            $user = new Users();
            $o = new self();
            $o->userId = $userId;
            $o->operationId = $operationId;
            try {
                $operation->load();
                $user->alias = $operation->optDocName;
                $doctor = current($user->find());
                if ($doctor instanceof Users) {
                    $o->save();
                    $borrow->userId = $doctor->id;
                    $borrow->save();
                } else {
                    throw new Exception("{$user->alias} 不存在");
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            return $o;
        } else {
            throw new Exception('用户ID或手术ID不是数字');
        }

    }

    /**
     * 检测收藏是否存在
     * @return boolean 存在返回true 不存在返回false
     */
    public function exists() {
        $data = $this->find(array(
            'limit' => 1,
        ));
        if (current($data) === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 删除用户收藏的手术
     * @param int $userId
     * @param int $operationId
     * @return Fav
     * @throws Exception 如果没找到手术或医生或收藏会抛异常
     */
    public static function cancelFav($userId, $operationId) {
        if (ctype_digit((string)$userId) && ctype_digit((string)$operationId)) {
            $operation = new Operations();
            try {
                $operation->load($operationId);
                $user = new Users();
                $user->alias = $operation->optDocName;
                $doctor = current($user->find());
                if ($doctor instanceof Users) {
                    $fav = new self();
                    $fav->userId = $userId;
                    $fav->operationId = $operationId;
                    /*@var $favObject Fav*/
                    /*@var $borrowObject Borrow*/
                    if (($favObject = current($fav->find()))) {
                        $borrow = new Borrow();
                        $borrow->userId = $doctor->id;
                        $borrow->operationId = $operationId;
                        $borrowObject = current($borrow->find());
                        if ($borrowObject instanceof Borrow) $borrowObject->delete();
                        return $favObject->delete();
                    } else {
                        throw new Exception("用户{$userId} 没有收藏手术 {$operation->optName}");
                    }
                } else {
                    throw new Exception("手术视频医生:{$doctor->alias} 没有找到");
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        } else {
            throw new Exception("用户ID或手术ID不是数字");
        }

    }
}
?>
