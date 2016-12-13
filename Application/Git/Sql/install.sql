CREATE TABLE `ly_git_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group` varchar(11) NOT NULL DEFAULT '' COMMENT '分组',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '导航标题',
  `type` varchar(15) NOT NULL DEFAULT '' COMMENT '导航类型',
  `value` text COMMENT '导航值',
  `target` varchar(11) NOT NULL DEFAULT '' COMMENT '打开方式',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台导航表';

INSERT INTO `ly_git_nav` (`id`, `group`, `pid`, `title`, `type`, `value`, `target`, `icon`, `create_time`, `update_time`, `sort`, `status`) VALUES ('1', 'main', '0', '发现', 'link', 'Git/Index/lists', '', '', '1468514235', '1468572489', '0', '1');
INSERT INTO `ly_git_nav` (`id`, `group`, `pid`, `title`, `type`, `value`, `target`, `icon`, `create_time`, `update_time`, `sort`, `status`) VALUES ('2', 'main', '0', '帮助', 'page', '<div class=\"scrollblock block-title\">\r\n  <h1>\r\n    <span style=\"color:inherit;font-family:inherit;font-size:30px;line-height:1.1;\">链接与资源</span> \r\n </h1>\r\n</div>\r\n<p>\r\n  <h3>\r\n    图形化界面\r\n </h3>\r\n <p>\r\n   <br />\r\n  </p>\r\n  <ul>\r\n    <li>\r\n      <a href=\"http://gitx.laullon.com/\">GitX (L) (OSX, open source)</a> \r\n   </li>\r\n   <li>\r\n      <a href=\"http://www.git-tower.com/\">Tower (OSX)</a> \r\n    </li>\r\n   <li>\r\n      <a href=\"http://www.sourcetreeapp.com/\">Source Tree (OSX, free)</a> \r\n    </li>\r\n   <li>\r\n      <a href=\"http://mac.github.com/\">GitHub for Mac (OSX, free)</a> \r\n    </li>\r\n   <li>\r\n      <a href=\"https://itunes.apple.com/gb/app/gitbox/id403388357?mt=12\">GitBox (OSX)</a> \r\n    </li>\r\n </ul>\r\n <p>\r\n   <br />\r\n  </p>\r\n  <h3>\r\n    指南与手册\r\n </h3>\r\n <p>\r\n   <br />\r\n  </p>\r\n  <ul>\r\n    <li>\r\n      <a href=\"http://book.git-scm.com/\">Git 社区参考书</a> \r\n   </li>\r\n   <li>\r\n      <a href=\"http://progit.org/book/\">专业 Git</a> \r\n   </li>\r\n   <li>\r\n      <a href=\"http://think-like-a-git.net/\">如 git 思考</a> \r\n    </li>\r\n </ul>\r\n <p>\r\n   <ul>\r\n      <li>\r\n        <a href=\"http://help.github.com/\">GitHub 帮助</a>\r\n     </li>\r\n   </ul>\r\n   <p>\r\n     <br />\r\n    </p>\r\n    <p>\r\n     <strong>下面整理一些在使用OpenCMFgit服务时容易遇到的问题：</strong>\r\n   </p>\r\n  </p>\r\n  <p>\r\n   <span style=\"font-family:\'Lantinghei SC\', \'Open Sans\', Arial, \'Hiragino Sans GB\', \'Microsoft YaHei\', STHeiti, \'WenQuanYi Micro Hei\', SimSun, sans-serif;font-size:14px;text-align:center;white-space:normal;\">报错：</span>\r\n  </p>\r\n  <p>\r\n   <span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">error:&nbsp;RPC&nbsp;failed;&nbsp;result=22,&nbsp;HTTP&nbsp;code&nbsp;=&nbsp;411</span>\r\n  </p>\r\n  <p>\r\n   <span style=\"font-size:14px;\"><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">fatal:&nbsp;The&nbsp;remote&nbsp;</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">end</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">&nbsp;hung&nbsp;up&nbsp;unexpectedly\r\nfatal:&nbsp;The&nbsp;remote&nbsp;</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">end</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">&nbsp;hung&nbsp;up&nbsp;unexpectedly\r\nEverything&nbsp;up-</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">to</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">-</span><span class=\"hljs-built_in\" style=\"box-sizing:inherit;color:#268BD2;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">date</span><br />\r\n</span>\r\n  </p>\r\n  <p>\r\n   原因：<span style=\"color:#293136;font-family:arial, helvetica, sans-serif;font-size:16px;white-space:normal;\">默认 Git 设置 http post 的缓存为 1MB，将其设置为 500MB</span>\r\n  </p>\r\n  <p>\r\n   解决：<span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">git&nbsp;config&nbsp;</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">http</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">.postBuffer&nbsp;&nbsp;</span><span class=\"hljs-number\" style=\"box-sizing:inherit;color:#2AA198;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">524288000</span>\r\n </p>\r\n  <p>\r\n   <span class=\"hljs-number\" style=\"box-sizing:inherit;color:#2AA198;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\"><br />\r\n</span>\r\n </p>\r\n</p>', '', '', '1468514385', '1468810670', '0', '1');


CREATE TABLE `ly_git_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(127) NOT NULL DEFAULT '' COMMENT '标题',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `abstract` varchar(255) DEFAULT '' COMMENT '摘要',
  `content` text COMMENT '内容',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章列表';

CREATE TABLE `ly_git_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `name` varchar(127) NOT NULL DEFAULT '' COMMENT '项目名称',
  `title` varchar(127) NOT NULL DEFAULT '' COMMENT '项目标题',
  `abstract` varchar(255) NOT NULL DEFAULT '' COMMENT '项目描述',
  `is_private` int(1) NOT NULL DEFAULT '0' COMMENT '是否私有项目',
  `repo_name` varchar(127) NOT NULL DEFAULT '' COMMENT '版本库名称',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '查看次数',
  `star_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Star次数',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Git项目表';

CREATE TABLE `ly_git_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `data_id` int(11) DEFAULT NULL COMMENT 'git仓库',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Git项目成员表';
