<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace User\Model;

use Common\Model\ModelModel;

/**
 * 用户字段模型
 * 该类参考了OneThink的部分实现
 * @author huajie <banhuajie@163.com>
 */
class AttributeModel extends ModelModel
{
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'user_attribute';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('name', 'require', '字段名必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '/^[a-zA-Z][\w_]{1,29}$/', '字段名不合法', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', 'checkName', '字段名已存在', self::MUST_VALIDATE, 'callback', self::MODEL_BOTH),
        array('title', '1,100', '字段定义不能超过100个字符', self::VALUE_VALIDATE, 'length', self::MODEL_BOTH),
        array('type', 'require', '字段类型必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('tip', '1,100', '备注不能超过100个字符', self::VALUE_VALIDATE, 'length', self::MODEL_BOTH),
        array('type_id', 'require', '未选择操作的用户类型', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
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
     * 检查同一张表是否有相同的字段
     * @author huajie <banhuajie@163.com>
     */
    protected function checkName()
    {
        $map['name']    = array('eq', I('post.name'));
        $map['type_id'] = array('eq', I('post.type_id'));
        $id             = I('post.id');
        if (!empty($id)) {
            $map['id'] = array('neq', $id);
        }
        $result = $this->where($map)->find();
        return empty($result);
    }
}
