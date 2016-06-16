<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 活动信息 控制器 by tangjian 

include 'content.php';

class action extends Content
{
    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'action';
        $this->baseurl = 'index.php?d=admin&c=action';
        $this->table = 'fm_action';
        $this->add_view = 'action_add'; // 添加页
    }
    
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
    
        if ($data['title'] == "") {
            show_msg('标题不能为空');
        }
    
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);
			adminlog('修改信息: '.$this->control.' -> '.$id);           
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $query = $this->db->insert($this->table, $data);
			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());            
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
    }
    
}
