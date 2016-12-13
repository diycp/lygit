<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Git\Controller;

use GitElephant\Repository;
use Home\Controller\HomeController;
use Think\Page;

/**
 * 默认控制器
 * @author jry <598821125@qq.com>
 */

class IndexController extends HomeController
{
    /**
     * 默认方法
     * @author jry <598821125@qq.com>
     */
    public function index()
    {
        $p                 = $_GET["p"] ?: 1;
        $map['status']     = 1;
        $map['is_private'] = 0;
        $index_object      = D('Index');
        $data_list         = $index_object
            ->page($p, C('ADMIN_PAGE_ROWS'))
            ->order('view_count desc')
            ->where($map)
            ->select();
        $page = new Page(
            $index_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );

        // 我的项目
        $my_repo_public = $index_object
            ->order('id desc')
            ->where(array('status' => 1, 'uid' => is_login(), 'is_private' => 0))
            ->select();
        $this->assign('my_repo_public', $my_repo_public);
        $my_repo_private = $index_object
            ->order('id desc')
            ->where(array('status' => 1, 'uid' => is_login(), 'is_private' => 1))
            ->select();
        $this->assign('my_repo_private', $my_repo_private);

        // 我参加的
        $member_list = D('Member')->where(array('status' => 1, 'uid' => is_login()))->getField(data_id, true);
        foreach ($member_list as $val) {
            $my_repo_member[] = $index_object->find($val);
        }
        $this->assign('my_repo_member', $my_repo_member);

        $this->assign('data_list', $data_list);
        $this->assign('page', $page->show());
        $this->assign('meta_title', "Git");
        $this->display();
    }

    /**
     * 列表
     * @author jry <598821125@qq.com>
     */
    public function lists()
    {
        // 搜索
        $keyword = I('keyword', '', 'string');
        if ($keyword) {
            $condition                  = array('like', '%' . $keyword . '%');
            $map['name|title|abstract'] = array(
                $condition,
                $condition,
                $condition,
                '_multi' => true,
            );
        }

        $p                 = $_GET["p"] ?: 1;
        $map['status']     = 1;
        $map['is_private'] = 0;
        $index_object      = D('Index');
        $data_list         = $index_object
            ->page($p, C('ADMIN_PAGE_ROWS'))
            ->order('view_count desc')
            ->where($map)
            ->select();
        $page = new Page(
            $index_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );

        // 我的项目
        $my_repo_public = $index_object
            ->order('id desc')
            ->where(array('status' => 1, 'uid' => is_login(), 'is_private' => 0))
            ->select();
        $this->assign('my_repo_public', $my_repo_public);
        $my_repo_private = $index_object
            ->order('id desc')
            ->where(array('status' => 1, 'uid' => is_login(), 'is_private' => 1))
            ->select();
        $this->assign('my_repo_private', $my_repo_private);

        // 我参加的
        $member_list = D('Member')->where(array('status' => 1, 'uid' => is_login()))->getField(data_id, true);
        foreach ($member_list as $val) {
            $my_repo_member[] = $index_object->find($val);
        }
        $this->assign('my_repo_member', $my_repo_member);

        $this->assign('data_list', $data_list);
        $this->assign('page', $page->show());
        $this->assign('meta_title', "Git");
        $this->display();
    }

    /**
     * 列表
     * @author jry <598821125@qq.com>
     */
    public function my()
    {
        // 获取列表
        $map["status"] = array("egt", "0"); // 禁用和正常状态
        $p             = $_GET["p"] ?: 1;
        $map['uid']    = $this->is_login();
        $model_object  = D("Index");
        $data_list     = $model_object
            ->page($p, C("ADMIN_PAGE_ROWS"))
            ->where($map)
            ->order("sort desc,id desc")
            ->select();
        $page = new Page(
            $model_object->where($map)->count(),
            C("ADMIN_PAGE_ROWS")
        );

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle("我的Git") // 设置页面标题
            ->addTopButton("addnew") // 添加新增按钮
            ->setSearch("请输入ID/标题", U("index"))
            ->addTableColumn("id", "ID")
            ->addTableColumn("name_url", "项目名称")
            ->addTableColumn("title", "项目标题")
            ->addTableColumn("create_time", "创建时间", "time")
            ->addTableColumn("sort", "排序")
            ->addTableColumn("status", "状态", "status")
            ->addTableColumn("right_button", "操作", "btn")
            ->setTableDataList($data_list) // 数据列表
            ->setTableDataPage($page->show()) // 数据列表分页
            ->addRightButton("edit") // 添加编辑按钮
            ->addRightButton("delete") // 添加删除按钮
            ->setTemplate(C('USER_CENTER_LIST'))
            ->display();
    }

    /**
     * 新增
     * @author jry <598821125@qq.com>
     */
    public function add()
    {
        $uid = $this->is_login();
        if (IS_POST) {
            $model_object = D("Index");
            $data         = $model_object->create(format_data());
            if ($data) {
                // 创建git仓库
                switch (PHP_OS) {
                    case 'Linux':
                        $repo_root = '/home/git_repo/';
                        break;
                    case 'Darwin':
                        $repo_root = '/Users/Jry/git_repo/';
                        break;
                    default:
                        $repo_root = 'C:/git_repo/';
                }
                if (C('git_config.repo_root')) {
                    $repo_root = C('git_config.repo_root');
                }

                // 创建文件夹
                if (!is_dir($repo_root . $data['uid'])) {
                    exec('cd ' . $repo_root . '  2>&1;mkdir ' . $data['uid'] . ' 2>&1', $output, $return_val);
                    if ($return_val == 1) {
                        $this->error($output[0]);
                    }
                }
                if (!is_dir($repo_root . $data['uid'] . '/' . $data['repo_name'] . '.git')) {
                    exec('cd ' . $repo_root . $data['uid'] . '; mkdir ' . $data['repo_name'] . '.git', $output, $return_val);
                    if ($return_val == 1) {
                        $this->error($output[0]);
                    }
                } else {
                    $this->error('已存在改仓库');
                }

                // 初始化仓库
                try {
                    $repo = new Repository($repo_root . $data['uid'] . '/' . $data['repo_name'] . '.git');
                } catch (\Exception $e) {
                    exit('版本库不存在');
                }
                try {
                    $repo->init(true);
                    $is_bare = $repo->isBare();
                } catch (\Exception $e) {
                    $this->error("创建失败");
                }
                if ($is_bare === true) {
                    // 添加记录
                    $id = $model_object->add($data);
                    if ($id) {
                        $this->success("创建成功", U("Git/Index/detail", array('id' => $id)));
                    } else {
                        $this->error("创建失败" . $model_object->getError());
                    }
                }
            } else {
                $this->error($model_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle("创建") // 设置页面标题
                ->setPostUrl(U("add")) // 设置表单提交地址
                ->addFormItem("name", "text", "项目名称", "项目名称")
                ->addFormItem("title", "text", "项目标题", "项目标题")
                ->addFormItem("abstract", "textarea", "项目描述", "项目描述")
                ->addFormItem("is_private", "radio", "私有项目", "私有项目", array('0' => '否', '1' => '是'))
                ->setTemplate(C('USER_CENTER_FORM'))
                ->display();
        }
    }

    /**
     * 编辑
     * @author jry <598821125@qq.com>
     */
    public function edit($id)
    {
        $uid = $this->is_login();
        if (IS_POST) {
            $model_object = D("Index");
            $data         = $model_object->create(format_data());
            if ($data) {
                $id = $model_object->save($data);
                if ($id !== false) {
                    $this->success("更新成功", U("index"));
                } else {
                    $this->error("更新失败" . $model_object->getError());
                }
            } else {
                $this->error($model_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle("编辑") // 设置页面标题
                ->setPostUrl(U("edit")) // 设置表单提交地址
                ->addFormItem("id", "hidden", "ID", "ID")
                ->addFormItem("name", "text", "项目名称", "项目名称")
                ->addFormItem("title", "text", "项目标题", "项目标题")
                ->addFormItem("abstract", "textarea", "项目描述", "项目描述")
                ->addFormItem("is_private", "radio", "私有项目", "私有项目", array('0' => '否', '1' => '是'))
                ->setTemplate(C('USER_CENTER_FORM'))
                ->setFormData(D("Index")->find($id))
                ->display();
        }
    }

    /**
     * 详情
     * @author jry <598821125@qq.com>
     */
    public function detail($id, $branch = 'master', $path = '', $commit = '', $tag = '', $history = false, $blob = '')
    {
        switch (PHP_OS) {
            case 'Linux':
                $repo_root = '/home/git_repo/';
                break;
            case 'Darwin':
                $repo_root = '/Users/Jry/git_repo/';
                break;
            default:
                $repo_root = 'C:/git_repo/';
                $git_bin   = new \GitElephant\GitBinary('git');
        }
        if (C('git_config.repo_root')) {
            $repo_root = C('git_config.repo_root');
        }

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object         = D('Member');
        $info['member_status'] = $member_object->get_status($info['id']);
        if ($info['is_private']) {
            if ($info['uid'] !== is_login() && !$info['member_status']) {
                $this->error('您无权查看该项目');
            }
        }

        // 项目成员
        $info['member_list'] = $member_object->get_member($info['id']);

        // 演示信息
        $demo_object       = D('Git/Demo');
        $info['demo_info'] = $demo_object->where(array('repo_id' => $info['id']))->find();

        // 阅读量加1
        if (!$path && !$commit && !$tag) {
            $result = $index_object->where(array('id' => $id))->SetInc('view_count');
        }

        // 获取版本库信息
        try {
            $repo = new Repository($repo_root . $info['uid'] . '/' . $info['repo_name'] . '.git', $git_bin);
        } catch (\Exception $e) {
            exit('版本库不存在');
        }
        if ($repo) {
            $info['branches'] = $repo->getBranches();
            if (!$info['branches']) {
                redirect(U('Git/Index/blank', array('id' => $id)));
            }
            $info['branch'] = $repo->getBranch($branch); // 获取当前分支信息
            $info['tags']   = $repo->getTags();
            if ($history) {
                $log = $repo->getLog($branch, null, 30, 0);
                foreach ($log as $key => $commit) {
                    $info['history'][$key]['message']           = $commit->getMessage();
                    $info['history'][$key]['sha']               = $commit->getSha();
                    $info['history'][$key]['author']            = $commit->getAuthor();
                    $info['history'][$key]['datetimeauthor']    = $commit->getDatetimeAuthor()->format('Y-m-d H:i:s');
                    $info['history'][$key]['datetimecommitter'] = $commit->getDatetimeCommitter()->format('Y-m-d H:i:s');
                }
            } else {
                $caller = $repo->getCaller();
                if ($commit) {
                    $sha = $commit;
                } elseif ($tag) {
                    $info['tag'] = $repo->getTag($tag);
                    $sha         = $info['tag']->getSha();
                } else {
                    $sha = $info['branch']->getSha();
                }
                $info['count_commits'] = $repo->countCommits($sha);

                // 读区README的内容
                try {
                    $info['readme'] = $caller->execute('cat-file -p ' . $sha . ':README.md')->getRawOutput();
                    $encode         = mb_detect_encoding($info['readme'], array('GB2312', 'GBK', 'cp936'));
                    if ($encode) {
                        $info['readme'] = iconv($encode, "UTF-8", $info['readme']);
                    }
                    $parsedown           = new \Parsedown();
                    $info['readme_html'] = $parsedown->text($info['readme']);
                } catch (\Exception $e) {}

                // 获取目录
                if ($path) {
                    // 转换目录标记
                    $path = './' . preg_replace('/-/', '/', $path);
                    $tree = $repo->getTree($repo->getCommit($sha), $path);
                } else {
                    $tree = $repo->getTree($repo->getCommit($sha));
                }
                if ($tree) {
                    foreach ($tree as $key => $val) {
                        $info['tree'][$key]['type'] = $val->getType();
                        $info['tree'][$key]['sha']  = $val->getSha();
                        $info['tree'][$key]['size'] = $val->getSize();
                        $info['tree'][$key]['name'] = $val->getName();
                        $info['tree'][$key]['path'] = $val->getPath();
                    }
                }
                // 查看文件详情
                if ($blob) {
                    $cat          = new \GitElephant\Command\CatFileCommand($repo);
                    $info['blob'] = $cat->contentBySha($blob);
                    $caller       = $repo->getCaller();
                    $info['blob'] = htmlspecialchars($caller->execute($info['blob'])->getRawOutput());
                }
            }
        }

        $this->assign('info', $info);
        $this->assign('meta_title', $info['name']);
        $this->display();
    }

    /**
     * 空版本库
     * @author jry <598821125@qq.com>
     */
    public function blank($id)
    {
        $uid = $this->is_login();

        switch (PHP_OS) {
            case 'Linux':
                $repo_root = '/home/git_repo/';
                break;
            case 'Darwin':
                $repo_root = '/Users/Jry/git_repo/';
                break;
            default:
                $repo_root = 'C:/git_repo/';
                $git_bin   = new \GitElephant\GitBinary('git');
        }
        if (C('git_config.repo_root')) {
            $repo_root = C('git_config.repo_root');
        }

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object         = D('Member');
        $info['member_status'] = $member_object->get_status($info['id']);
        if ($info['is_private']) {
            if ($info['uid'] !== is_login() && !$info['member_status']) {
                $this->error('您无权查看该项目');
            }
        }

        // 获取版本库信息
        try {
            $repo = new Repository($repo_root . $info['uid'] . '/' . $info['repo_name'] . '.git', $git_bin);
        } catch (\Exception $e) {
            exit('版本库不存在');
        }
        if ($repo) {
            $info['branches'] = $repo->getBranches();
            if ($info['branches']) {
                redirect(U('Git/Index/detail', array('id' => $info['id'])));
            }
        }

        $this->assign('info', $info);
        $this->assign('meta_title', $info['name']);
        $this->display();
    }

    /**
     * 分支列表
     * @author jry <598821125@qq.com>
     */
    public function branch($id)
    {
        $uid = $this->is_login();

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object         = D('Member');
        $info['member_status'] = $member_object->get_status($info['id']);
        if ($info['is_private']) {
            if ($info['uid'] !== is_login() && !$info['member_status']) {
                $this->error('您无权查看该项目');
            }
        }

        // 版本库
        switch (PHP_OS) {
            case 'Linux':
                $repo_root = '/home/git_repo/';
                break;
            case 'Darwin':
                $repo_root = '/Users/Jry/git_repo/';
                break;
            default:
                $repo_root = 'C:/git_repo/';
        }
        if (C('git_config.repo_root')) {
            $repo_root = C('git_config.repo_root');
        }
        // 获取版本库信息
        try {
            $repo = new Repository($repo_root . $info['uid'] . '/' . $info['repo_name'] . '.git');
        } catch (\Exception $e) {
            exit('版本库不存在');
        }
        if ($repo) {
            $info['branches'] = $repo->getBranches();
            if (!$info['branches']) {
                redirect(U('Git/Index/blank', array('id' => $id)));
            }
        }

        $this->assign('info', $info);
        $this->assign('meta_title', '分支列表');
        $this->display();
    }

    /**
     * 项目成员
     * @author jry <598821125@qq.com>
     */
    public function member($id)
    {
        $uid = $this->is_login();

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object         = D('Member');
        $info['member_status'] = $member_object->get_status($info['id']);
        if ($info['is_private']) {
            if ($info['uid'] !== is_login() && !$info['member_status']) {
                $this->error('您无权查看该项目');
            }
        }

        // 项目成员
        $member_list = $member_object->get_member($info['id']);
        $user_object = D('Admin/User');
        foreach ($member_list as $key => $val) {
            $info['member_list'][$val] = $user_object->getUserInfo($val);
        }

        $this->assign('info', $info);
        $this->assign('meta_title', '项目成员');
        $this->display();
    }

    /**
     * 设置
     * @author jry <598821125@qq.com>
     */
    public function setting($id)
    {
        $uid = $this->is_login();

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object         = D('Member');
        $info['member_status'] = $member_object->get_status($info['id']);
        if ($info['is_private']) {
            if ($info['uid'] !== is_login() && !$info['member_status']) {
                $this->error('您无权查看该项目');
            }
        }

        $this->assign('info', $info);
        $this->assign('meta_title', $info['name']);
        $this->display();
    }

    /**
     * 打包下载
     * @author jry <598821125@qq.com>
     */
    public function download($id, $sha = '')
    {
        $uid = $this->is_login();

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object         = D('Member');
        $info['member_status'] = $member_object->get_status($info['id']);
        if ($info['is_private']) {
            if ($info['uid'] !== is_login() && !$info['member_status']) {
                $this->error('权限不足');
            }
        }

        // 版本库
        switch (PHP_OS) {
            case 'Linux':
                $repo_root = '/home/git_repo/';
                break;
            case 'Darwin':
                $repo_root = '/Users/Jry/git_repo/';
                break;
            default:
                $repo_root = 'C:/git_repo/';
        }
        if (C('git_config.repo_root')) {
            $repo_root = C('git_config.repo_root');
        }
        // 获取版本库信息
        try {
            $git = new \PHPGit\Git();
            $git->setRepository($repo_root . $info['uid'] . '/' . $info['repo_name'] . '.git');
        } catch (\Exception $e) {
            exit('版本库不存在');
        }
        if ($git) {
            if (!$sha) {
                if ($_GET['commit']) {
                    $sha = $_GET['commit'];
                } elseif ($_GET['tag']) {
                    $sha = $_GET['tag'];
                } else {
                    $sha = $_GET['branch'] ?: 'master';
                }
            }
            $path = $repo_root . $info['name'] . '-' . $sha . '.zip';
            $git->archive($path, $sha, null, ['format' => 'zip']);
            if (is_file($path)) {
                // 执行下载
                header("Content-Description: File Transfer");
                header('Content-type: application/x-zip-compressed');
                header('Content-Length:' . filesize($path));
                if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
                    // for IE
                    header('Content-Disposition: attachment; filename="' . rawurlencode($info['name'] . '-' . $sha . '.zip') . '"');
                } else {
                    header('Content-Disposition: attachment; filename="' . $info['name'] . '-' . $sha . '.zip' . '"');
                }
                readfile($path);
            }
        }
    }

    /**
     * 从远程项目创建
     * @author jry <598821125@qq.com>
     */
    public function clone_from_remote($id)
    {
        $uid = $this->is_login();

        // 查询项目信息
        $map['status'] = 1;
        $index_object  = D('Index');
        $info          = $index_object->where($map)->find($id);

        // 权限
        $member_object         = D('Member');
        $info['member_status'] = $member_object->get_status($info['id']);
        if ($info['is_private']) {
            if ($info['uid'] !== is_login() && !$info['member_status']) {
                $this->error('权限不足');
            }
        }

        switch (PHP_OS) {
            case 'Linux':
                $repo_root = '/home/git_repo/';
                break;
            case 'Darwin':
                $repo_root = '/Users/Jry/git_repo/';
                break;
            default:
                $repo_root = 'C:/git_repo/';
                $git_bin   = new \GitElephant\GitBinary('git');
        }
        if (C('git_config.repo_root')) {
            $repo_root = C('git_config.repo_root');
        }

        // 获取版本库信息
        try {
            $repo = new Repository($repo_root . $info['uid'] . '/' . $info['repo_name'] . '.git', $git_bin);
        } catch (\Exception $e) {
            exit('版本库不存在');
        }
        if ($repo) {
            $info['branches'] = $repo->getBranches();
            if ($info['branches']) {
                $this->error('该项目不是一个空仓库');
            }
        }

        // 获取远程仓库
        switch (I('remote_code')) {
            case 'corethink':
                $url = 'https://github.com/ijry/corethink.git';
                break;
            case 'self':
                $url = I('repo_url');
                if (!$url) {
                    $this->error('请填写仓库地址');
                }
                break;
            default:
                $this->error('请选择项目来源');
                break;
        }
        $remote = $repo->getRemotes();
        if (count($remote) == 0) {
            $repo->addRemote('origin', $url);
        }
        set_time_limit(0); //超时状态
        $repo->pull('origin', 'master', true);
        $this->success('正在克隆请等待...');
    }

    /**
     * 设置一条或者多条数据的状态
     * @author jry <598821125@qq.com>
     */
    public function setStatus($model = CONTROLLER_NAME)
    {
        $ids = I('request.ids');
        if (I('request.status') == 'delete') {

            // 删除项目成员
            $con['data_id'] = $ids;
            $member_model   = D('Member');
            $count          = $member_model->where($con)->count();
            if ($count > 0) {
                $result = $member_model->where($con)->delete();
                if (!$result) {
                    $this->error('删除项目成员出错');
                }
            }

            // Docker检查
            $demo_model = D('Demo');
            $count      = $demo_model->where(array('repo_id' => $ids))->count();
            if ($count > 0) {
                $this->error('该项目有绑定的演示未删除');
            }

            // 数据库检查
            $mysql_model = D('Mysql');
            $count       = $mysql_model->where(array('repo_id' => $ids))->count();
            if ($count > 0) {
                $this->error('该项目有绑定的mysql未删除');
            }
        }
        parent::setStatus($model);
    }
}
