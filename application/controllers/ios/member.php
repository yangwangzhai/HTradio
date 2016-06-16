<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    /*
 * android 会员接口
 */
include 'api.php';

class member extends Api
{

    function __construct ()
    {
        parent::__construct();
    }
    
    // 注册
    public function regist ()
    {
        $postdate = array(
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'email' => trim($_POST['email']),
                'nickname' => trim($_POST['nickname']),
                'tel' => trim($_POST['tel']),
                'regtime' => time(),
                'status' => 1,
                'lastlogintime' => time()
        );
        
        if ($postdate['username'] == "" || $postdate['password'] == "") {
            error(1, '用户名或者密码不能为空');
        }
        $query = $this->db->query(
                "select id from fly_member where username='{$postdate[username]}' limit 1");
        if ($query->num_rows() > 0) {
            error(2, '用户名已经存在，请换一个');
        }
        $query = $this->db->query(
                "select id from fly_member where email='{$postdate[email]}' limit 1");
        if ($query->num_rows() > 0) {
            error(3, '邮箱已经被使用，请换一个');
        }
        
        $postdate['password'] = get_password($postdate['password']);
        $query = $this->db->insert('fly_member', $postdate);
        if ($this->db->insert_id() > 0) {
            $postdate['id'] = $this->db->insert_id();
            $postdate['groupid'] = 1;
            exit(json_encode($postdate));
            
            // 统计加1
            $this->load->model('stat_model');
            $this->stat_model->day_save('members');
        }
    }
    
    // 修改
    public function update ()
    {
        $uid = intval($_POST['uid']);
        $postdate = array(                
                'email' => trim($_POST['email']),
                'nickname' => trim($_POST['nickname']),
                'tel' => trim($_POST['tel']),
                'sign' => trim($_POST['sign'])
                );
                
        if ( empty($uid) ) {
            error(1, 'uid is null');
        }
        
        $query = $this->db->query(
                "select id from fly_member where email='$postdate[email]' limit 1");
        $row = $query->row_array();
        if ( !empty($row) ) {
            if ($row['id'] != $uid ) {
                error(2, 'email used');
            }
        }
        
        $query = $this->db->update('fly_member', $postdate, 
                'id = ' . $uid);
        echo 'ok';
    }
    
    // 获取一条会员全部信息
    function get_one ()
    {
        $uid = intval($_GET['uid']);
        
        if (! empty($uid)) {
            $query = $this->db->get_where('fly_member', 'id = ' . $uid, 1);
            $row = $query->row_array();
            $row['avatar'] = new_thumbname($row['avatar'], 100, 100);
            unset($row['password']);
            echo json_encode($row);
        }
    }
    
    // 会员 找回密码
    function find_password ()
    {
        $result = '';
        $email = trim($_POST['email']);
        
        if (! isemail($email)) {
            error(1, "邮箱格式错误");
        }
        
        $query = $this->db->get_where('fly_member', array(
                'email' => $email
        ), 1);
        $row = $query->row_array();
        if (empty($row)) {
            error(2, "没有找到该邮箱");
        }
        
        // 修改密码
        $this->load->helper('string');
        $radom = strtolower(random_string('alpha', 6));
        $new_password = get_password($radom);
        $this->db->update('fly_member', array(
                'password' => $new_password
        ), array(
                'email' => $email
        ));
        
        // 发送新密码到该邮箱
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.qq.com';
        $config['smtp_user'] = '1574147371@qq.com';
        $config['smtp_pass'] = 'ruantejishu000';
        $config['smtp_port'] = '25';
        $config['newline'] = "\r\n";
        $this->email->initialize($config);
        $this->email->from('1574147371@qq.com', '微路');
        $this->email->to($email);
        $this->email->subject('微路客户端 - 找回密码');
        $this->email->message("微路客服提示您：您的新密码已重置为  $radom ");
        $this->email->send();
        
        echo 'ok';
        
        // 第一步 发送邮箱验证码到他邮箱
        
        // 第二步 验证 验证码是否正确
        
        // 第三步 重新设置新密码
    }
} // 类结束
