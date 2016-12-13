<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Git\Model;

use Common\Model\ModelModel;

/**
 * 成员模型
 * @author jry <598821125@qq.com>
 */
class MemberModel extends ModelModel
{
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'Git_Member';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('data_id', 'require', '项目ID必须', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
        array('uid', 'require', '用户ID必须', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('status', 1, self::MODEL_INSERT, 'string'),
    );

    /**
     * 获取当前用户是否是指定项目
     * @author jry <598821125@qq.com>
     */
    public function get_status($data_id)
    {
        $con            = array();
        $con['uid']     = is_login();
        $con['data_id'] = $data_id;
        $con['status']  = 1;
        $result         = $this->where($con)->find();
        return $result;
    }

    /**
     * 获取项目成员列表
     * @author jry <598821125@qq.com>
     */
    public function get_member($data_id)
    {
        $con            = array();
        $con['data_id'] = $data_id;
        $con['status']  = 1;
        $result         = $this->where($con)->getField('uid', true);
        return $result;
    }
}
