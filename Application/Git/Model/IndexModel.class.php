<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
/**
 * 默认模型
 * @author jry <598821125@qq.com>
 */
namespace Git\Model;

use Common\Model\ModelModel;

class IndexModel extends ModelModel
{
    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'git_index';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('name', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '3,32', '用户名长度为3-32个字符', self::MUST_VALIDATE, 'length', self::MODEL_INSERT),
        array('name', '/^(?!_)(?!\d)(?!.*?_$)[\w]+$/', '名称只可含有数字、字母、下划线且不以下划线开头结尾，不以数字开头！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('abstract', 'require', '描述不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', 'checkName', '该项目名称已存在', self::MUST_VALIDATE, 'callback', self::MODEL_BOTH), //用户名禁止注册
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('repo_name', 'name', self::MODEL_INSERT, 'field'),
        array('uid', 'is_login', self::MODEL_INSERT, 'function'),
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 检测名称重复
     * @param  string $username 用户名
     * @return boolean ture 未禁用，false 禁止注册
     */
    protected function checkName($name)
    {
        $con['name'] = $name;
        $con['uid']  = is_login();
        $info        = $this->where($con)->find();
        if ($info && $info['id'] !== I('id')) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    protected function _after_find(&$result, $options)
    {
        $result['name_url'] = '<a target="_blank" href="' . U('Git/Index/detail', array('id' => $result['id']), true, true) . '">' . $result['name'] . '</a>';
        $result['user']     = D('Admin/User')->getUserInfo($result['uid']);
    }

    /**
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    protected function _after_select(&$result, $options)
    {
        foreach ($result as &$record) {
            $this->_after_find($record, $options);
        }
    }
}
