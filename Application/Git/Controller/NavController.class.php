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
 * 导航控制器
 * @author jry <598821125@qq.com>
 */

class NavController extends HomeController
{
    /**
     * 单页类型
     * @author jry <598821125@qq.com>
     */
    public function page($id)
    {
        $nav_object    = D('Git/Nav');
        $con['id']     = $id;
        $con['status'] = 1;
        $info          = $nav_object->where($con)->find();
        if (!$info) {
            $this->error('文章不存在或已禁用');
        }

        $this->assign('info', $info);
        $this->assign('meta_title', $info['title']);
        $this->display();
    }

    /**
     * 文章列表
     * @author jry <598821125@qq.com>
     */
    public function lists($cid)
    {
        $nav_object    = D('Git/Nav');
        $con['id']     = $cid;
        $con['status'] = 1;
        $info          = $nav_object->where($con)->find();
        if (!$info) {
            $this->error('文章不存在或已禁用');
        }

        // 文章列表
        $map['status'] = 1;
        $map['cid']    = $cid;
        $p             = $_GET["p"] ?: 1;
        $post_object   = D('Git/Post');
        $data_list     = $post_object
            ->where($map)
            ->page($p, C("ADMIN_PAGE_ROWS"))
            ->order("sort desc,id desc")
            ->select();
        $page = new Page(
            $post_object->where($map)->count(),
            C("ADMIN_PAGE_ROWS")
        );

        $this->assign('data_list', $data_list);
        $this->assign('page', $page->show());
        $this->assign('meta_title', $info['title']);
        $this->display();
    }

    /**
     * 文章详情
     * @author jry <598821125@qq.com>
     */
    public function post($id)
    {
        $post_object   = D('Git/Post');
        $con['id']     = $id;
        $con['status'] = 1;
        $info          = $post_object->where($con)->find();
        if (!$info) {
            $this->error('文章不存在或已禁用');
        }

        // 阅读量加1
        $result = $post_object->where(array('id' => $id))->SetInc('view_count');

        $this->assign('info', $info);
        $this->assign('meta_title', $info['title']);
        $this->display('page');
    }
}
