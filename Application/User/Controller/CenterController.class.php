<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace User\Controller;

use Home\Controller\HomeController;

/**
 * 用户中心控制器
 * @author jry <598821125@qq.com>
 */
class CenterController extends HomeController
{
    /**
     * 修改昵称
     * @author jry <598821125@qq.com>
     */
    public function nickname()
    {
        $uid = $this->is_login();
        if (IS_POST) {
            if (I('post.nickname')) {
                $user_object = D('User/User');
                $result      = $user_object->where(array('id' => $uid))
                    ->setField('nickname', I('post.nickname'));
                if ($result) {
                    $this->success('昵称修改成功');
                } else {
                    $this->error('昵称修改失败' . $user_object->getError());
                }
            } else {
                $this->error('请填写昵称');
            }
        } else {
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('修改昵称') // 设置页面标题
                ->setPostUrl(U('')) // 设置表单提交地址
                ->addFormItem('nickname', 'text', '用户昵称')
                ->setFormData(D('User/User')->detail($uid))
                ->setTemplate(C('USER_CENTER_FORM'))
                ->display();
        }
    }

    /**
     * 修改头像
     * @author jry <598821125@qq.com>
     */
    public function avatar()
    {
        $uid = $this->is_login();
        if (IS_POST) {
            if ($_POST) {
                if (!$_POST['avatar']['src'] || !$_POST['avatar']['w'] || !$_POST['avatar']['h'] || $_POST['avatar']['x'] === '' || $_POST['avatar']['y'] === '') {
                    $this->error('参数不完整');
                }
                $result = D('Admin/Upload')->crop($_POST['avatar']);
                if ($result && $result['error'] != 1) {
                    $user_object = D('User/User');
                    $result      = $user_object->where(array('id' => $uid))->setField('avatar', $result['id']);
                    if ($result) {
                        $this->success('头像修改成功');
                    } else {
                        $this->error('头像修改失败' . $user_object->getError());
                    }
                } else {
                    $this->error('头像保存失败');
                }
            } else {
                $this->error('请选择文件');
            }
        } else {
            $this->assign('user_info', D('User/User')->detail($uid));
            $this->assign('meta_title', '修改头像');
            $this->display();
        }
    }

    /**
     * 用户修改信息
     * @author jry <598821125@qq.com>
     */
    public function profile()
    {
        $uid = $this->is_login();

        // 获取当前用户
        $user_object = D('User/User');
        $user_info   = $user_object->detail($uid);
        $user_type   = $user_info['user_type'];

        // 获取扩展字段
        $map['type_id']             = array('eq', $user_type);
        $attribute_list[$user_type] = D('User/Attribute')->where($map)->order('id asc')->select();

        // 修改信息
        if (IS_POST) {
            // 强制设置用户ID
            $_POST['uid'] = $uid;
            $_POST        = format_data();

            // 保存昵称
            if (I('post.nickname')) {
                $result = $user_object->where(array('id' => $uid))->setField('nickname', I('post.nickname'));
                if ($result === false) {
                    $this->error('昵称修改失败' . $user_object->getError());
                }
            } else {
                $this->error('请填写昵称');
            }

            // 存储用户扩展信息
            if ($user_type) {
                $type_data = array();
                foreach ($attribute_list[$user_type] as $key => $val) {
                    if (I($val['name'])) {
                        $type_data[$key]['uid']     = $uid;
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
                    $index_attr_model->where(array('uid' => $uid))->delete();
                    $type_data_result = $index_attr_model->addAll($type_data);
                    if (!$type_data_result) {
                        $this->error('修改用户扩展信息出错' . $index_attr_model->getError());
                    }
                }
            }
            $this->success('修改信息成功');
        } else {
            // 解析字段options
            $user_type_info = D('User/Type')->find($user_type);
            if ($attribute_list[$user_type]) {
                // 增加昵称表单
                $nick['name']                      = 'nickname';
                $nick['title']                     = '昵称';
                $nick['type']                      = 'text';
                $nick['value']                     = $user_info['nickname'];
                $new_attribute_list[$user_type][0] = $nick;
                foreach ($attribute_list[$user_type] as $attr) {
                    $attr['options']                                      = \Util\Str::parseAttr($attr['options']);
                    $new_attribute_list[$user_type][$attr['id']]          = $attr;
                    $new_attribute_list[$user_type][$attr['id']]['value'] = $user_info[$attr['name']];
                }
                $new_attribute_list_sort['group']['type']                                        = 'group';
                $new_attribute_list_sort['group']['options'][$user_type_info['name']]['title']   = $user_type_info['title'] . '信息';
                $new_attribute_list_sort['group']['options'][$user_type_info['name']]['options'] = $new_attribute_list[$user_type];
            }

            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('修改信息') // 设置页面标题
                ->setPostUrl(U('')) // 设置表单提交地址
                ->setExtraItems($new_attribute_list_sort)
                ->setTemplate(C('USER_CENTER_FORM'))
                ->display();
        }
    }
}
