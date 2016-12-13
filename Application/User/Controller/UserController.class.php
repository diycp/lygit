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
 * 用户控制器
 * @author jry <598821125@qq.com>
 */
class UserController extends HomeController
{
    /**
     * 登陆
     * @author jry <598821125@qq.com>
     */
    public function login()
    {
        if (IS_POST) {
            $account  = I('username');
            $password = I('password');
            if (!$account) {
                $this->error('请输入账号！');
            }
            if (!$password) {
                $this->error('请输入密码！');
            }
            $user_object = D('User/User');
            $uid         = $user_object->login($account, $password);
            if ($uid) {
                $this->success('登录成功！', cookie('forward') ?: C('HOME_PAGE'));
            } else {
                $this->error($user_object->getError());
            }
        } else {
            if (is_login()) {
                $this->error("您已登录系统", cookie('forward') ?: C('HOME_PAGE'));
            }
            $this->assign('meta_title', '用户登录');
            $this->display();
        }
    }

    /**
     * 注销
     * @author jry <598821125@qq.com>
     */
    public function logout()
    {
        $logout = true;

        // 注销
        if ($logout) {
            session('user_auth', null);
            session('user_auth_sign', null);
            if (C('SESSION_OPTIONS.type') === 'Sql') {
                $res = M('admin_session')->where(array('session_id' => session_id()))->setField('uid', '0');
            }
            $this->success('注销成功！', cookie('forward') ?: C('HOME_PAGE'));
        } else {
            $this->error('注销出错' . $push_object->getError());
        }
    }

    /**
     * 用户注册
     * @author jry <598821125@qq.com>
     */
    public function register()
    {
        if (IS_POST) {
            if (!C('user_config.reg_toggle')) {
                $this->error('注册已关闭！');
            }
            $reg_type = I('post.reg_type');
            if (!in_array($reg_type, C('user_config.allow_reg_type'))) {
                $this->error('该注册方式已关闭，请选择其它方式注册！');
            }
            $reg_data = array();
            switch ($reg_type) {
                case 'username': //用户名注册
                    //图片验证码校验
                    if (!$this->check_verify(I('post.verify'))) {
                        $this->error('验证码输入错误！');
                    }
                    if (I('post.email')) {
                        $reg_data['email'] = I('post.email');
                    }
                    if (I('post.mobile')) {
                        $reg_data['mobile'] = I('post.mobile');
                    }
                    break;
            }

            // 构造注册数据
            $reg_data['user_type'] = I('post.user_type') ? I('post.user_type') : 1;
            $reg_data['nickname']  = I('post.nickname') ? I('post.nickname') : I('post.username');
            $reg_data['username']  = I('post.username');
            $reg_data['password']  = I('post.password');
            if ($_POST['repassword']) {
                $reg_data['repassword'] = $_POST['repassword'];
            }
            $reg_data['reg_type'] = I('post.reg_type');
            $user_object          = D('User/User');
            $data                 = $user_object->create($reg_data);
            if ($data) {
                $id = $user_object->add($data);
                if ($id) {
                    session('reg_verify', null);
                    $user_info = $user_object->login($data['username'], I('post.password'), true, true);
                    $url       = U('/user', '', true, true);
                    $this->success('注册成功', $url);
                } else {
                    $this->error('注册失败' . $user_object->getError());
                }
            } else {
                $this->error('注册失败' . $user_object->getError());
            }
        } else {
            if (is_login()) {
                $this->error("您已登陆系统", cookie('forward') ?: C('HOME_PAGE'));
            }
            $this->assign('meta_title', '用户注册');
            $this->display();
        }
    }
    /**
     * 图片验证码生成，用于登录和注册
     * @author jry <598821125@qq.com>
     */
    public function verify($vid = 1)
    {
        $verify_config = array(
            'fontSize' => 30,
            'length'   => 4,
            'useNoise' => true,
            'expire'   => 60,
        );
        $verify = new \Think\Verify($verify_config);
        $verify->entry($vid);
    }

    /**
     * 检测验证码
     * @param  integer $id 验证码ID
     * @return boolean 检测结果
     */
    public function check_verify($code, $vid = 1)
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $vid);
    }
}
