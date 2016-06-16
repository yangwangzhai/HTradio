<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 角色 企业信息控制器 by tangjian 
class Role extends CI_Controller
{

    private $uid = 0;

    function __construct ()
    {
        parent::__construct();
        
        $this->uid = $this->session->userdata('id');
        if (! $this->uid) {
            show_msg('请先登录', 'admin.php');
        }
    }
    
    // 首页 列表
    public function index ()
    {
        $query = $this->db->query('select * from fm_role');
        $data['list'] = $query->result_array();
        
        $this->load->view('admin/role_list', $data);
    }
    
    // 权限设置页面
    public function purview ()
    {
        $list = include 'application/cache/category.php';
        
        $this->load->library('tree');
        $this->tree->init($list);
        $string = '<tr>';
        $string .= '<td> $spacer $name </td>'; // 栏目
        $string .= '<td><input name=\"checkbox\" type=\"checkbox\" checked=\"checked\" /></td>'; // 显示
        $string .= '<td><input name=\"checkbox\" type=\"checkbox\" checked=\"checked\" /></td>'; // 显示
        $string .= '<td><input name=\"checkbox\" type=\"checkbox\" checked=\"checked\" /></td>'; // 显示
        $string .= '<td><input name=\"checkbox\" type=\"checkbox\" checked=\"checked\" /></td>'; // 显示
        
        $string .= '</tr>'; // 显示
        
        $data['tree'] = $this->tree->get_tree(0, $string);
        
        $this->load->view('admin/role_purview', $data);
    }
}
	




