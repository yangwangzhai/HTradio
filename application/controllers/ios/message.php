<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * android  私信 私聊 接口
 */
include 'api.php';

class message extends Api
{
    function __construct ()
    {
        parent::__construct();
        
        //$this->load->model('stat_model');
    }
    
    // 未读信息数
    function unread()
    {
        $uid = intval($_GET['uid']);
        if(empty($uid)) {
            error(1,'uid is null');
        }
        $query = $this->db->query("SELECT from_uid,COUNT(*)AS total FROM fly_message
WHERE to_uid=$uid AND isread=0
GROUP BY from_uid");
        $data = $query->result_array();
        if(!empty($data)) {
            $total = 0;
            foreach ($data as $r){
                $total += $r['total'];
                
            }
            echo count($data).','.$total;
        } else {
            echo "0";
        }    
        
        
    }
    
   
} // 类结束
