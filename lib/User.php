<?php
//dengjing34@vip.qq.com
class User extends Data {

    public $id, $userName, $alias, $avatar, $password, $job, $dept, $mobile, $status, $sex, $role, $roleId, $email, $description, $createdTime, $updatedTime, $attributeData;
    public $workId;
    const STATUS_ACTIVE = 1;
    const STATUS_LEAVE = 2;
    const STATUS_STOP = 3;

    const SEX_MALE = 1;
    const SEX_FEMAL = 2;

    public static $_status = array(
        self::STATUS_ACTIVE => '正常',
        self::STATUS_LEAVE => '暂停',
        self::STATUS_STOP => '冻结',
    );

    public static $_job = array();

    public static $_dept = array();


    public static $formFields = array(
        'userName' => array(
            'text' => '登录名称', 'required' => true, 'rule' => '/^[a-z]+$/', 'hint' => '只允许小写字母', 'size' => '30', 'tip' => '不符合规范,只允许小写字母'
        ),
        'alias' => array(
            'text' => '中文名称', 'required' => true, 'hint' => '不能为空', 'size' => '30', 'tip' => '请填写用户的中文名称'
        ),
        'workId' => array(
            'text' => '工号', 'required' => true, 'hint' => '不能为空', 'size' => '30', 'tip' => '请填写用户的工号'
        ),
        'avatar' => array(
            'text' => '照片', 'type' => 'file', 'required' => true, 'hint' => '请上传长宽为200*239像素的照片', 'size' => 40, 'tip' => '必须上传照片', //'resizable' => true, //'watermark' => Uploader::WATER_MARK_TEXT,
        ),
        'job' => array(
            'text' => '职称', 'required' => true, 'type' => 'select', 'options' => array(), 'tip' => '职称未选择',
        ),
        'dept' => array(
            'text' => '科室', 'required' => true, 'type' => 'select', 'options' => array(), 'tip' => '科室未选择',
        ),
        'password' => array(
            'text' => '登录密码', 'type' => 'password', 'required' => true, 'size' => '30','tip' => '必填',
        ),
        'mobile' => array(
            'text' => '手机号码', 'required' => true, 'rule' => '/^1[358]\d{9}$/', 'size' => '30', 'tip' => '不是有效的手机号码',
        ),
        'email' => array(
            'text' => '邮箱地址', 'required' => true, 'rule' => '/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/', 'size' => '30', 'tip' => '不符合规范', 'hint' => '如:xyz@abc.com',
        ),
        'description' => array(
            'text' => '简介', 'type' => 'ckeditor', 'width' => 850
        ),
        'sex' => array(
            'text' => '性别', 'required' => true, 'type' => 'radio', 'options' => array(), 'tip' => '未选择性别',
        ),
        'status' => array(
            'text' => '状态', 'required' => true, 'type' => 'select', 'options' => array(), 'tip' => '状态未选择',
        ),
        'roleId' => array(
            'text' => '角色', 'required' => true, 'type' => 'select', 'options' => array(), 'tip' => '角色未选择',
        ),
    );

    public static $_holdUsers = array ('admin','dengjing');//不允许删除的用户名字

    public static $_sex = array(
        self::SEX_MALE => '先生',
        self::SEX_FEMAL => '女士',
    );
    function __construct() {
        $options = array(
            'key' => 'id',
            'table' => 't_user',
            'columns' => array(
                'id' => 'id',
                'userName' => 'userName',
                'alias' => 'alias',
                'workId' => 'workId',
                'avatar' => 'avatar',
                'job' => 'job',
                'dept' => 'dept',
                'password' => 'password',
                'mobile' => 'mobile',
                'status' => 'status',
                'sex' => 'sex',
                'role' => 'role',
                'roleId' => 'roleId',
                'email' => 'email',
                'description' => 'description',
                'createdTime' => 'createdTime',
                'updatedTime' => 'updatedTime',
                'attributeData' => 'attributeData',
            ),
            'saveNeeds' => array(
                'userName',
                'password',
                'mobile',
                'status',
                'role',
                'roleId',
            )
        );
        parent::init($options);
    }

    function save() {
        $insertFlag = false;
        if (!preg_match("/^1[358]\d{9}$/", $this->mobile)) throw new Exception("mobile:{$this->mobile} is not a regular mobile!");
        if (!preg_match("/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/", $this->email)) throw new Exception("email:{$this->email} is not a regular email address!");
        if (is_null($this->roleId)) throw new Exception("please select a role for {$this->userName}");
        if (strlen($this->workId) == 0) throw new Exception('工号不能为空');
        if (is_null($this->id)) {
            $this->password = md5($this->userName . $this->password);
            $this->createdTime = $this->updatedTime = time();
            foreach (array ('userName', 'mobile', 'email', 'workId') as $val) {
                $obj = new $this->className;
                $obj->$val = $this->$val;
                $total = $obj->count(array(
                    'limit' => 1
                ));
                if ($total > 0) throw new Exception("{$val}:{$this->{$val}} exists!\n");
            }
            $insertFlag = true;
        } else {
            foreach (array ('userName', 'mobile', 'email', 'workId') as $val) {
                $obj = new $this->className;
                $obj->$val = $this->$val;
                $total = $obj->count(array(
                    'limit' => 1,
                    'whereAnd' => array(
                        array('id', "<> '{$this->id}'"),
                    )
                ));
                if ($total > 0) throw new Exception("{$val}:{$this->{$val}} exists!\n");
            }
            $this->updatedTime = time();
        }
        $role = new Role();
        $role->id = $this->roleId;
        try {
            $role->load();
            $this->role = $role->name;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        //$this->htmlspecialchars();
        parent::save();
    }

    function  delete($value = null) {
        if ($value == 1) throw new Exception("[admin]无法删除");
        $obj = new $this->className;
        $obj->id = $value;
        try {
            $obj->load();
            if (in_array($obj->userName, self::$_holdUsers)) throw new Exception("用户[{$obj->userName}]因受保护而无法删除");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        parent::delete($value);
    }

    public function getAvatarUrl() {
        return Url::fileUrl($this->avatar);
    }

    public function getAvatarImage(){
        $src = $this->getAvatarUrl();
        return $src ? "<img src=\"{$src}\" />" : null;
    }

    public function getJob() {
        if (self::$_job) return self::$_job[$this->job];
        self::$_job = Job::getJobOptions();
        return self::$_job[$this->job];
    }

    public function getDept() {
        if (self::$_dept) return self::$_dept[$this->dept];
        self::$_dept = Dept::getDeptOptions();
        return self::$_dept[$this->dept];
    }

    public function operationCount() {
        $o = new Operations();
        $o->optDocName = $this->alias;
        return $o->count();
    }

}

?>
