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

/**
 * HTTP服务
 * @author jry <598821125@qq.com>
 */
class EmptyController extends HomeController
{
    /**
     * HTTP服务方法
     * param $user 用户名
     * param $name 项目名称
     * param $info git参数
     * http://www.lingyun.net/git/admin/opencmf.git
     * @author jry <598821125@qq.com>
     */
    public function _empty()
    {
        $path_info    = $_SERVER["PATH_INFO"];
        $temp         = preg_split("/\//", $path_info, 3, PREG_SPLIT_NO_EMPTY); // 取出类似/info/refs传递给git_http_backend
        $path_info    = '/' . end($temp);
        $username     = $temp[0]; // 用户名
        $project_name = $temp[1]; // 项目名称
        // dump($temp);

        // 获取项目创建者信息及项目信息
        $uid = D('Admin/User')->getFieldByUsername($username, 'id');
        if (!$uid) {
            $this->error('用户信息错误');
        }
        $con         = array();
        $con['name'] = str_replace('.git', '', $project_name);
        $con['uid']  = $uid;
        $info        = D('Index')->where($con)->find();

        // git 客户端访问
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'git/') !== false) {
            // 项目是否私有
            if ($info['is_private']) {
                if (!isset($_SERVER["PHP_AUTH_USER"])) {
                    header("WWW-Authenticate: Basic realm=\"USER LOGIN\"");
                    header("HTTP/1.0 401 Unauthorized");
                    echo "请输入您的用户名/邮箱密码";
                    exit;
                } else {
                    // 验证用户名密码
                    $user_object = D('User/User');
                    $user_auth   = $user_object->login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], false);
                    if (!$user_auth) {
                        // 如果是错误的用户名称/密码对，强制再验证
                        Header("WWW-Authenticate: Basic realm=\"USER LOGIN\"");
                        Header("HTTP/1.0 401 Unauthorized");
                        echo "错误:" . $user_object->getError();
                        exit;
                    } else {
                        // 验证当前认证通过的用户是目标仓库的管理员或者项目成员
                        $member_uid_list   = D('Member')->get_member($info['id']);
                        $member_uid_list[] = $info['uid'];
                        if (!in_array($user_auth, $member_uid_list)) {
                            Header("WWW-Authenticate: Basic realm=\"USER LOGIN\"");
                            Header("HTTP/1.0 401 Unauthorized");
                            echo "权限不足";
                            exit;
                        }
                    }
                }
            } else {
                // 公开项目 push 时也需要用户认证，认证用户是否是项目成员，非项目成员只有只读权限，不具有push权限。
                switch ($_GET['service']) {
                    case 'git-upload-pack': // 客户端在执行fetch命令
                        # code...
                        break;
                    case 'git-receive-pack': // 客户端在执行push命令
                        if (!isset($_SERVER["PHP_AUTH_USER"])) {
                            header("WWW-Authenticate: Basic realm=\"USER LOGIN\"");
                            header("HTTP/1.0 401 Unauthorized");
                            echo "请输入您的用户名/邮箱密码";
                            exit;
                        } else {
                            // 验证用户名密码
                            $user_object = D('User/User');
                            $user_auth   = $user_object->login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], false);
                            if (!$user_auth) {
                                // 如果是错误的用户名称/密码对，强制再验证
                                Header("WWW-Authenticate: Basic realm=\"USER LOGIN\"");
                                Header("HTTP/1.0 401 Unauthorized");
                                echo "错误:" . $user_object->getError();
                                exit;
                            } else {
                                // 验证当前认证通过的用户是目标仓库的管理员或者项目成员
                                $member_uid_list   = D('Member')->get_member($info['id']);
                                $member_uid_list[] = $info['uid'];
                                if (!in_array($user_auth, $member_uid_list)) {
                                    Header("WWW-Authenticate: Basic realm=\"USER LOGIN\"");
                                    Header("HTTP/1.0 401 Unauthorized");
                                    echo "权限不足";
                                    exit;
                                }
                            }
                        }
                        break;
                    default:
                        break;
                }
            }

            // 处理HTTP请求
            switch (PHP_OS) {
                case 'Linux':
                    $git_http_backend = '/usr/lib/git-core/git-http-backend';
                    $repo_root        = '/home/git_repo/';
                    break;
                case 'Darwin':
                    $git_http_backend = '/Applications/Xcode.app/Contents/Developer/usr/libexec/git-core/git-http-backend';
                    $repo_root        = '/Users/Jry/git_repo/';
                    break;
                default:
                    $git_http_backend = 'C:/Program Files (x86)/git/libexec/git-core/git-http-backend.exe';
                    $repo_root        = 'C:/git_repo';
            }
            if (C('git_config.git_http_backend')) {
                $git_http_backend = C('git_config.git_http_backend');
            }
            if (C('git_config.repo_root')) {
                $repo_root = C('git_config.repo_root');
            }

            $request_headers = getallheaders();
            $php_input       = file_get_contents("php://input");

            $settings = array(
                0 => array("pipe", "r"),
                1 => array("pipe", "w"),
            );

            $env = array(
                "GIT_PROJECT_ROOT"    => $repo_root . $uid . '/' . $info['repo_name'] . '.git',
                "GIT_HTTP_EXPORT_ALL" => "1",
                "PATH_INFO"           => $path_info,
                "REMOTE_USER"         => isset($_SERVER["REMOTE_USER"]) ? $_SERVER["REMOTE_USER"] : 'smart-http',
                "REMOTE_ADDR"         => isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "",
                "REQUEST_METHOD"      => isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "",
                "QUERY_STRING"        => isset($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] : "",
                "CONTENT_TYPE"        => isset($request_headers["Content-Type"]) ? $request_headers["Content-Type"] : "",
            );

            // 连接git_http_backend
            $process = proc_open("\"" . $git_http_backend . "\"", $settings, $pipes, null, $env);
            if (is_resource($process)) {
                fwrite($pipes[0], $php_input);
                fclose($pipes[0]);
                $return_output = stream_get_contents($pipes[1]);
                fclose($pipes[1]);
                $return_code = proc_close($process);
            }

            if (!empty($return_output)) {
                list($response_headers, $response_body) = $response = preg_split("/\R\R/", $return_output, 2, PREG_SPLIT_NO_EMPTY);
                foreach (preg_split("/\R/", $response_headers) as $response_header) {
                    header($response_header);
                }

                // 开启gzip压缩
                if (isset($request_headers["Accept-Encoding"]) && strpos($request_headers["Accept-Encoding"], "gzip") !== false) {
                    $gzipoutput = gzencode($response_body, 6);
                    ini_set("zlib.output_compression", "Off");
                    header("Content-Encoding: gzip");
                    header("Content-Length: " . strlen($gzipoutput));
                    echo $gzipoutput;
                } else {
                    echo $response_body;
                }
            }

            // 调试
            $debug = false;
            if ($debug) {
                $log = "";
                $log .= "\$_GET = " . print_r($_GET, true);
                $log .= "\$_POST = " . print_r($_POST, true);
                $log .= "\$_SERVER = " . print_r($_SERVER, true);
                $log .= "\$request_headers = " . print_r($request_headers, true);
                $log .= "\$env = " . print_r($env, true);
                $log .= "\$php_input = " . PHP_EOL . $php_input . PHP_EOL;
                $log .= "\$return_output = " . PHP_EOL . $return_output . PHP_EOL;
                $log .= "\$response = " . print_r($response, true);
                $log .= str_repeat("-", 80) . PHP_EOL;
                $log .= PHP_EOL;
                if (isset($_GET["service"]) && $_GET["service"] == "git-receive-pack") {
                    file_put_contents("LOG_RESPONSE.log", "");
                }

                file_put_contents("LOG_RESPONSE.log", $log, FILE_APPEND);
            }
        } else { // web浏览器访问
            redirect(U('/repo/' . $info['id'], true, true));
        }
    }
}
