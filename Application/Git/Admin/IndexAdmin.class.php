<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Git\Admin;

use Admin\Controller\AdminController;
use Think\Page;

/**
 * 默认控制器
 * @author jry <598821125@qq.com>
 */
class IndexAdmin extends AdminController
{
    /**
     * 默认方法
     * @author jry <598821125@qq.com>
     */
    public function index()
    {
        // 获取列表
        $map["status"] = array("egt", "0"); // 禁用和正常状态
        $p             = $_GET["p"] ?: 1;
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
        $builder->setMetaTitle("列表") // 设置页面标题
            ->addTopButton("addnew") // 添加新增按钮
            ->addTopButton("resume") // 添加启用按钮
            ->addTopButton("forbid") // 添加禁用按钮
            ->setSearch("请输入ID/标题", U("index"))
            ->addTableColumn("id", "ID")
            ->addTableColumn("uid", "UID")
            ->addTableColumn("name", "项目名称")
            ->addTableColumn("title", "项目标题")
            ->addTableColumn("create_time", "创建时间", "time")
            ->addTableColumn("sort", "排序")
            ->addTableColumn("status", "状态", "status")
            ->addTableColumn("right_button", "操作", "btn")
            ->setTableDataList($data_list) // 数据列表
            ->setTableDataPage($page->show()) // 数据列表分页
            ->addRightButton("edit") // 添加编辑按钮
            ->addRightButton("forbid") // 添加禁用/启用按钮
            ->addRightButton("delete") // 添加删除按钮
            ->display();
    }

    /**
     * 新增
     * @author jry <598821125@qq.com>
     */
    public function add()
    {
        if (IS_POST) {
            $model_object = D("Index");
            $data         = $model_object->create(format_data());
            if ($data) {
                $id = $model_object->add($data);
                if ($id) {
                    $this->success("新增成功", U("index"));
                } else {
                    $this->error("新增失败" . $model_object->getError());
                }
            } else {
                $this->error($model_object->getError());
            }
        } else {
            // 使用FormBuilder快速建立表单页面
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle("新增") // 设置页面标题
                ->setPostUrl(U("add")) // 设置表单提交地址
                ->addFormItem("name", "text", "项目名称", "项目名称")
                ->addFormItem("title", "text", "项目标题", "项目标题")
                ->addFormItem("abstract", "textarea", "项目描述", "项目描述")
                ->addFormItem("is_private", "radio", "私有项目", "私有项目", array('0' => '否', '1' => '是'))
                ->display();
        }
    }

    /**
     * 编辑
     * @author jry <598821125@qq.com>
     */
    public function edit($id)
    {
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
                ->setFormData(D("Index")->find($id))
                ->display();
        }
    }
}
