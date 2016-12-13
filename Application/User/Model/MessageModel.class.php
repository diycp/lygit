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
 * 消息模型
 * @author jry <598821125@qq.com>
 */
class MessageModel extends ModelModel
{
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'user_message';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('title', 'require', '消息必须填写', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,1024', '消息长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('to_uid', 'require', '收信人必须填写', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('is_read', '0', self::MODEL_INSERT),
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('sort', '0', self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    protected function _after_find(&$result, $options)
    {
        $result['title'] = strip_tags($result['title']);
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

    /**
     * 消息类型
     * @author jry <598821125@qq.com>
     */
    public function message_type($id = null)
    {
        $list[0] = '系统消息';
        $list[1] = '评论消息';
        return isset($id) ? $list[$id] : $list;
    }

    /**
     * 发送消息
     * @param $send_data 消息类型
     * @param $send_type.email 是否通过系统消息通知
     * @param $send_type.email 是否通过邮件通知
     * @param $send_type.weixin 是否通过微信公众号推送（用户帐号需要绑定了微信）
     * @param $send_type.push 是否通过APP推送（用户帐号需要在某一台手机登陆）
     * @author jry <598821125@qq.com>
     */
    public function sendMessage($send_data, $send_type = array('message', 'email', 'weixin', 'push'))
    {
        $send_data['content'] = $send_data['content'] ?: $send_data['title']; //消息内容
        $msg_data['title']    = $send_data['title']; //消息标题
        $msg_data['content']  = $send_data['content'] ?: $send_data['title']; //消息内容
        $msg_data['to_uid']   = $send_data['to_uid']; //消息收信人ID
        $msg_data['type']     = $send_data['type'] ?: 0; //消息类型
        $msg_data['from_uid'] = $send_data['from_uid'] ?: 0; //消息发信人
        $msg_data['url']      = $send_data['url']; //消息额外URL
        $msg_data['remark']   = $send_data['remark']; //消息备注
        $data                 = $this->create($msg_data);
        if ($data) {
            // 系统消息通知（写进记录至user_message表即可）
            if (in_array('message', $send_type)) {
                $message_result = $this->add($data);
                if ($message_result) {
                    $return['message'] = true;
                }
            }

            // 返回结果
            return $return;
        } else {
            return false;
        }
    }

    /**
     * 获取当前用户未读消息数量
     * @param $type 消息类型
     * @author jry <598821125@qq.com>
     */
    public function newMessageCount($type = null)
    {
        $map['status']  = array('eq', 1);
        $map['to_uid']  = array('eq', is_login());
        $map['is_read'] = array('eq', 0);
        if ($type !== null) {
            $map['type'] = array('eq', $type);
        }
        return $this->where($map)->count();
    }
}
