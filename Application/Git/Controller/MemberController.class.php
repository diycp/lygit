<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Git\Controller;

use Home\Controller\HomeController;
use Think\Page;

/**
 * 成员控制器
 * @author jry <598821125@qq.com>
 */
class MemberController extends HomeController
{
    /**
     * 初始化方法
     * @author jry <598821125@qq.com>
     */
    protected function _initialize()
    {
        parent::_initialize();
        $this->is_login();
    }

    /**
     * 我的
     * @author jry <598821125@qq.com>
     */
    public function my()
    {
        $map['status'] = array('eq', '1'); // 禁用和正常状态
        $map['uid']    = $this->is_login();
        $p             = !empty($_GET["p"]) ? $_GET['p'] : 1;
        $mark_object   = D('Git/Member');
        $data_list     = $mark_object
            ->page($p, C('ADMIN_PAGE_ROWS'))
            ->where($map)
            ->order('id asc')
            ->select();
        $page = new Page(
            $mark_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );

        // 获取标题
        $index_object = D('Index');
        foreach ($data_list as &$val) {
            $temp            = $index_object->find($val['data_id']);
            $val['name_url'] = $temp['name_url'];
        }

        // 取消收藏按钮
        $attr['title'] = '退出项目';
        $attr['class'] = 'label label-danger-outline label-pill ajax-get';
        $attr['href']  = U('Git/Member/add', array(
            'data_id' => __data_id__,
        ));

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle("我参与的项目") // 设置页面标题
            ->addTableColumn("id", "ID")
            ->addTableColumn("name_url", "名称")
            ->addTableColumn("create_time", "创建时间", "time")
            ->addTableColumn("status", "状态", "status")
            ->addTableColumn("right_button", "操作", "btn")
            ->setTableDataList($data_list) // 数据列表
            ->setTableDataPage($page->show()) // 数据列表分页
            ->addRightButton("self", $attr) // 添加取消收藏按钮
            ->setTemplate(C('USER_CENTER_LIST'))
            ->setTableDataListKey('data_id')
            ->display();
    }

    /**
     * 添加项目成员
     * @author jry <598821125@qq.com>
     */
    public function add($data_id, $uid)
    {
        $member_object  = D('Git/Member');
        $con['data_id'] = $data_id;
        $con['uid']     = $uid;
        $find           = $member_object->where($con)->find();
        if ($find) {
            if ($find['status'] === '1') {
                $where['id'] = $find['id'];
                $result      = $member_object
                    ->where($where)
                    ->setField(array('status' => 0, 'update_time' => time()));
                if ($result) {
                    $return['status']        = 1;
                    $return['info']          = '移除成功' . $member_object->getError();
                    $return['follow_status'] = 0;
                } else {
                    $return['status']        = 0;
                    $return['info']          = '移除失败' . $member_object->getError();
                    $return['follow_status'] = 1;
                }
            } else {
                $where['id'] = $find['id'];
                $result      = $member_object
                    ->where($where)
                    ->setField(array('status' => 1, 'update_time' => time()));
                if ($result) {
                    $return['status']        = 1;
                    $return['info']          = '添加成功' . $member_object->getError();
                    $return['member_status'] = 1;
                } else {
                    $return['status'] = 0;
                    $return['info']   = '添加失败' . $member_object->getError();
                }
            }
        } else {
            $data = $member_object->create($con);
            if ($data) {
                $result = $member_object->add($data);
                if ($result) {
                    $return['status']        = 1;
                    $return['info']          = '添加成功' . $member_object->getError();
                    $return['member_status'] = 1;
                } else {
                    $return['status'] = 0;
                    $return['info']   = '添加失败' . $member_object->getError();
                }
            }
        }

        // 获取数据
        $user_info = D('Admin/User')->getUserInfo($uid);
        $repo_info = D('Git/Index')->find($data_id);

        // 发送消息
        if (1 == $return['member_status']) {
            $msg_data['content'] = $user_info['nickname'] . '您好：<br>' . '您已成功被加入Git项目' . $repo_info['name_url'];
        } else {
            $msg_data['content'] = $user_info['nickname'] . '您好：<br>' . '您已成功被移出Git项目' . $repo_info['name_url'];
        }
        $msg_data['to_uid'] = $uid;
        $msg_data['title']  = 'Git项目通知';
        $msg_data['url']    = U('Git/Index/detail/', array('id' => $data_id), true, true);
        $msg_return         = D('User/Message')->sendMessage($msg_data);

        // 返回结果
        $this->ajaxReturn($return);
    }

    /**
     * 搜索成员
     * @param $type 消息类型
     * @author jry <598821125@qq.com>
     */
    public function search($id, $keyword = '')
    {
        $uid = $this->is_login();

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object = D('Member');
        if ($info['is_private']) {
            if ($info['uid'] !== is_login()) {
                $this->error('您无权查看该项目');
            }
        }

        // 项目成员
        $member_list = $member_object->get_member($info['id']);

        // 获取用户基本信息
        $map           = array();
        $map['status'] = 1;
        if ($member_list) {
            $map['id'] = array('not in', $member_list);
        }

        // 关键字搜索
        $keyword = I('keyword', '', 'string');
        if ($keyword) {
            $condition                                = array('like', '%' . $keyword . '%');
            $map['id|nickname|username|email|mobile'] = array(
                $condition,
                $condition,
                $condition,
                $condition,
                $condition,
                '_multi' => true,
            );

            // 获取列表
            $p           = !empty($_GET["p"]) ? $_GET['p'] : 1;
            $user_object = D('User/User');
            $user_list   = $user_object
                ->page($p, 16)
                ->where($map)
                ->order('id desc')
                ->select();
            $page = new Page(
                $user_object
                    ->where($map)
                    ->count(),
                16
            );

            $this->assign('page', $page->show());
            $this->assign('user_list', $user_list);
        }

        $this->assign('info', $info);
        $this->assign('meta_title', '添加成员');
        $this->display();
    }
}
