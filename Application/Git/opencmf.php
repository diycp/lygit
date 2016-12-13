<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
// 模块信息配置
return array(
    // 模块信息
    'info'       => array(
        'name'        => 'Git',
        'title'       => 'Git',
        'icon'        => 'fa fa-git',
        'icon_color'  => '#F9B440',
        'description' => 'Git模块',
        'developer'   => '南京科斯克网络科技有限公司',
        'website'     => 'http://www.opencmf.cn',
        'version'     => '1.0.0',
    ),

    // 用户中心导航
    'user_nav'   => array(
        'center' => array(
            '0' => array(
                'title' => '我的项目',
                'icon'  => 'fa fa-git',
                'url'   => 'Git/Index/my',
                'color' => '#398CD2',
            ),
            '1' => array(
                'title' => '我参与的',
                'icon'  => 'fa fa-git',
                'url'   => 'Git/Member/my',
                'color' => '#DC6AC6',
            ),
        ),
        'main'   => array(
            '0' => array(
                'title' => '新建项目',
                'icon'  => 'fa fa-plus',
                'url'   => 'Git/Index/add',
            ),
        ),
    ),

    // 模块配置
    'config'     => array(
        'repo_root'    => array(
            'title' => '版本库根目录',
            'type'  => 'text',
            'value' => '/home/git_repo/',
        ),
        'http_backend' => array(
            'title' => 'http_backend路径',
            'type'  => 'text',
            'value' => '',
        ),
    ),

    // 后台菜单及权限节点配置
    'admin_menu' => array(
        '1'  => array(
            'pid'   => '0',
            'title' => 'Git',
            'icon'  => 'fa fa-git',
        ),
        '2'  => array(
            'pid'   => '1',
            'title' => 'Git管理',
            'icon'  => 'fa fa-folder-open-o',
        ),
        '3'  => array(
            'pid'   => '2',
            'title' => 'Git设置',
            'icon'  => 'fa fa-wrench',
            'url'   => 'Git/Index/module_config',
        ),
        '4'  => array(
            'pid'   => '2',
            'title' => '项目列表',
            'icon'  => 'fa fa-list',
            'url'   => 'Git/Index/index',
        ),
        '5'  => array(
            'pid'   => '4',
            'title' => '新增',
            'url'   => 'Git/Index/add',
        ),
        '6'  => array(
            'pid'   => '4',
            'title' => '编辑',
            'url'   => 'Git/Index/edit',
        ),
        '7'  => array(
            'pid'   => '4',
            'title' => '设置状态',
            'url'   => 'Git/Index/setStatus',
        ),
        '8'  => array(
            'pid'   => '2',
            'title' => '导航管理',
            'icon'  => 'fa fa-map-signs',
            'url'   => 'Git/Nav/index',
        ),
        '9'  => array(
            'pid'   => '8',
            'title' => '新增',
            'url'   => 'Git/Nav/add',
        ),
        '10' => array(
            'pid'   => '8',
            'title' => '编辑',
            'url'   => 'Git/Nav/edit',
        ),
        '11' => array(
            'pid'   => '8',
            'title' => '设置状态',
            'url'   => 'Git/Nav/setStatus',
        ),
    ),
);
