<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace User\Admin;

use Admin\Controller\AdminController;
use Think\Page;

/**
 * 用户控制器
 * @author jry <598821125@qq.com>
 */
class UserAdmin extends AdminController
{
    /**
     * 用户列表
     * @author jry <598821125@qq.com>
     */
    public function index()
    {
        // 搜索
        $keyword                                  = I('keyword', '', 'string');
        $condition                                = array('like', '%' . $keyword . '%');
        $map['id|username|nickname|email|mobile'] = array(
            $condition,
            $condition,
            $condition,
            $condition,
            $condition,
            '_multi' => true,
        );

        // 获取用户吧列表
        $p           = !empty($_GET["p"]) ? $_GET['p'] : 1;
        $user_object = D('User/User');
        $data_list   = $user_object
            ->page($p, C('ADMIN_PAGE_ROWS'))
            ->where($map)
            ->order('id desc')
            ->select();
        $page = new Page(
            $user_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('用户列表') // 设置页面标题
            ->addTopButton('addnew', array('href' => U('add', array('user_type' => 1)))) // 添加新增按钮
            ->addTopButton('resume') // 添加启用按钮
            ->addTopButton('forbid') // 添加禁用按钮
            ->addTopButton('recycle') // 添加删除按钮
            ->setSearch('请输入ID/用户名／邮箱／手机号', U('index'))
            ->addTableColumn('id', 'UID')
            ->addTableColumn('avatar', '头像', 'picture')
            ->addTableColumn('nickname', '昵称')
            ->addTableColumn('username', '用户名')
            ->addTableColumn('email', '邮箱')
            ->addTableColumn('mobile', '手机号')
            ->addTableColumn('score', '积分')
            ->addTableColumn('money', '余额')
            ->addTableColumn('create_time', '注册时间', 'time')
            ->addTableColumn('status', '状态', 'status')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($data_list) // 数据列表
            ->setTableDataPage($page->show()) // 数据列表分页
            ->addRightButton('edit') // 添加编辑按钮
            ->addRightButton('forbid') // 添加禁用/启用按钮
            ->addRightButton('recycle') // 添加删除按钮
            ->display();
    }

    /**
     * 新增用户
     * @author jry <598821125@qq.com>
     */
    public function add($user_type)
    {
        // 获取扩展字段
        $map['type_id']             = array('eq', $user_type);
        $attribute_list[$user_type] = D('User/Attribute')->where($map)->order('id asc')->select();

        // 新增用户
        if (IS_POST) {
            $user_object = D('User/User');
            $data        = $user_object->create();
            if ($data) {
                $id = $user_object->add();
                if ($id) {
                    // 存储用户扩展信息
                    if ($user_type) {
                        $type_data = array();
                        foreach ($attribute_list[$user_type] as $key => $val) {
                            if (I($val['name'])) {
                                $type_data[$key]['uid']     = $id;
                                $type_data[$key]['attr_id'] = $val['id'];
                                if (is_array(I($val['name']))) {
                                    $type_data[$key]['value'] = implode(',', I($val['name']));
                                } else {
                                    $type_data[$key]['value'] = I($val['name']);
                                }
                            }
                        }
                        if (count($type_data) > 0) {
                            $index_attr_model = D('UserAttr');
                            $type_data_result = $index_attr_model->addAll($type_data);
                            if (!$type_data_result) {
                                $this->error('添加用户扩展信息出错' . $index_attr_model->getError(), U('edit', array('id' => $id)));
                            }
                        }
                    }
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($user_object->getError());
            }
        } else {
            // 解析字段options
            $user_type_info = D('User/Type')->find($user_type);
            if ($attribute_list[$user_type]) {
                foreach ($attribute_list[$user_type] as $attr) {
                    $attr['options']                             = \Util\Str::parseAttr($attr['options']);
                    $new_attribute_list[$user_type][$attr['id']] = $attr;
                }
                $new_attribute_list_sort['group']['type']                                        = 'group';
                $new_attribute_list_sort['group']['options'][$user_type_info['name']]['title']   = $user_type_info['title'] . '扩展信息';
                $new_attribute_list_sort['group']['options'][$user_type_info['name']]['options'] = $new_attribute_list[$user_type];
            }

            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增用户') //设置页面标题
                ->setPostUrl(U('add')) //设置表单提交地址
                ->addFormItem('reg_type', 'hidden', '注册方式', '注册方式')
                ->addFormItem('user_type', 'hidden', '用户类型', '用户类型', select_list_as_tree('User/Type'))
                ->addFormItem('nickname', 'text', '昵称', '昵称')
                ->addFormItem('username', 'text', '用户名', '用户名')
                ->addFormItem('password', 'password', '密码', '密码')
                ->addFormItem('email', 'text', '邮箱', '邮箱')
                ->addFormItem('email_bind', 'radio', '邮箱绑定', '手机绑定', array('1' => '已绑定', '0' => '未绑定'))
                ->addFormItem('mobile', 'text', '手机号', '手机号')
                ->addFormItem('mobile_bind', 'radio', '手机绑定', '手机绑定', array('1' => '已绑定', '0' => '未绑定'))
                ->addFormItem('avatar', 'picture', '头像', '头像')
                ->setExtraItems($new_attribute_list_sort)
                ->setFormData(array('reg_type' => 'admin', 'user_type' => $user_type))
                ->display();
        }
    }

    /**
     * 编辑用户
     * @author jry <598821125@qq.com>
     */
    public function edit($id)
    {
        // 获取当前用户
        $user_object = D('User/User');
        $user_info   = $user_object->detail($id);
        $user_type   = $user_info['user_type'];

        // 获取扩展字段
        $map['type_id']             = array('eq', $user_type);
        $attribute_list[$user_type] = D('User/Attribute')->where($map)->order('id asc')->select();

        // 编辑用户
        if (IS_POST) {
            // 密码为空表示不修改密码
            if ($_POST['password'] === '') {
                unset($_POST['password']);
            }

            // 是否禁止修改超级管理员帐号
            if (APP_DEBUG !== true && $id === '1') {
                $this->error('非调试模式不允许后台修改超级管理员信息');
            }

            // 提交数据
            $user_object = D('User/User');
            $data        = $user_object->create();
            if ($data) {
                $result = $user_object
                    ->field('id,nickname,username,password,email,email_bind,mobile,mobile_bind,avatar,update_time')
                    ->save($data);
                if ($result) {
                    // 存储用户扩展信息
                    if ($user_type) {
                        $type_data = array();
                        foreach ($attribute_list[$user_type] as $key => $val) {
                            if (I($val['name'])) {
                                $type_data[$key]['uid']     = $id;
                                $type_data[$key]['attr_id'] = $val['id'];
                                if (is_array(I($val['name']))) {
                                    $type_data[$key]['value'] = implode(',', I($val['name']));
                                } else {
                                    $type_data[$key]['value'] = I($val['name']);
                                }
                            }
                        }
                        if (count($type_data) > 0) {
                            $index_attr_model = D('UserAttr');
                            $index_attr_model->where(array('uid' => $id))->delete();
                            $type_data_result = $index_attr_model->addAll($type_data);
                            if (!$type_data_result) {
                                $this->error('修改用户扩展信息出错' . $index_attr_model->getError(), U('edit', array('id' => $id)));
                            }
                        }
                    }
                    $this->success('信息修改成功', U('index'));
                } else {
                    $this->error('更新失败', $user_object->getError());
                }
            } else {
                $this->error($user_object->getError());
            }
        } else {
            // 去掉密码
            unset($info['password']);

            // 解析字段options
            $user_type_info = D('User/Type')->find($user_type);
            if ($attribute_list[$user_type]) {
                foreach ($attribute_list[$user_type] as $attr) {
                    $attr['options']                                      = \Util\Str::parseAttr($attr['options']);
                    $new_attribute_list[$user_type][$attr['id']]          = $attr;
                    $new_attribute_list[$user_type][$attr['id']]['value'] = $user_info[$attr['name']];
                }
                $new_attribute_list_sort['group']['type']                                        = 'group';
                $new_attribute_list_sort['group']['options'][$user_type_info['name']]['title']   = $user_type_info['title'] . '扩展信息';
                $new_attribute_list_sort['group']['options'][$user_type_info['name']]['options'] = $new_attribute_list[$user_type];
            }

            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑用户') // 设置页面标题
                ->setPostUrl(U('edit')) // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('user_type', 'radio', '用户类型', '用户类型', select_list_as_tree('User/Type'))
                ->addFormItem('nickname', 'text', '昵称', '昵称')
                ->addFormItem('username', 'text', '用户名', '用户名')
                ->addFormItem('password', 'password', '密码', '密码')
                ->addFormItem('email', 'text', '邮箱', '邮箱')
                ->addFormItem('email_bind', 'radio', '邮箱绑定', '手机绑定', array('1' => '已绑定', '0' => '未绑定'))
                ->addFormItem('mobile', 'text', '手机号', '手机号')
                ->addFormItem('mobile_bind', 'radio', '手机绑定', '手机绑定', array('1' => '已绑定', '0' => '未绑定'))
                ->addFormItem('avatar', 'picture', '头像', '头像')
                ->setExtraItems($new_attribute_list_sort)
                ->setFormData($user_info)
                ->display();
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @author jry <598821125@qq.com>
     */
    public function setStatus($model = CONTROLLER_NAME)
    {
        $ids = I('request.ids');
        if (is_array($ids)) {
            if (in_array('1', $ids)) {
                $this->error('超级管理员不允许操作');
            }
        } else {
            if ($ids === '1') {
                $this->error('超级管理员不允许操作');
            }
        }
        parent::setStatus($model);
    }
}
