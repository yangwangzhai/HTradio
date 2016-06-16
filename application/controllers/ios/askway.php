<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * 问路
 */
include 'api.php';

class askway extends Api
{
    
    function __construct ()
    {
        parent::__construct();
    }
    
    // 问路 列表 先获取路况表，如果是会员 则从会员获取数据，组合起来
    function lists ()
    {
        
        $sqls = '';
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $district = intval($_GET['district']);
        $street = mysql_real_escape_string($_GET['street']);
        $groupid = intval($_GET['groupid']);
        
        if ($district) {
            $sqls .= " AND district='$district' ";
        }
        if ($street) {
            $street = addslashes($street);
            $sqls .= " AND street like '{$street}%' ";
        }
        if ($groupid) {
            $sqls .= " AND groupid='{$groupid}' ";
        }
        
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_askway WHERE status=1 $sqls");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        $districts = $this->config->item('district');
        // 文字路况列表
        if ($count > $offset) {
            $sql = "SELECT id,uid,title,thumb,audio,audio_time,district,street,longlat,comments,typename,addtime FROM fly_askway WHERE status=1 $sqls ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {             
                $row['addtime'] = timeFromNow($row['addtime']);
                $row['thumb'] = new_thumbname($row['thumb'], 100, 100);
                $data[] = $row;
            }
            $data = addMember($data);
        }
        
        echo json_encode($data);
    }  
    
    
    // 文字路况 单条信息 包括发布会员的信息
    function get_one ()
    {
        $id = intval($_GET['id']);
        
        if (! empty($id)) {
            $query = $this->db->query(
                    "SELECT * FROM fly_askway WHERE id={$id} LIMIT 1");
            // $query = $this->db->query("SELECT a.*,b.nickname,b.avatar FROM
            // fly_askway a,fly_member b WHERE a.id={$id} AND a.uid=b.id
            // LIMIT 1");
            $row = $query->row_array();           
            $row['addtime'] = timeFromNow($row['addtime']);
            $row['thumb'] = new_thumbname($row['thumb'], 100, 100);
            $row['nickname'] = "游客";
            $row['avatar'] = "";
            if ($row['uid']) {
                $query = $this->db->query(
                        "SELECT nickname,avatar FROM fly_member WHERE id={$row[uid]} LIMIT 1");
                $member = $query->row_array();
                $row['nickname'] = $member['nickname'];
                $row['avatar'] = new_thumbname($member['avatar'], 100, 100);
            }
            
            echo json_encode($row);
        }
    }
    
    // 文字路况 提交保存
    function save ()
    {
        $districts = $this->config->item('district');
        $district = trim($_POST['district']);
        $district = intval(array_search($district, $districts));
        
        $data = array(               
                'uid' => intval($_POST['uid']),
                'title' => trim($_POST['title']),
                'district' => $district,
                'street' => trim($_POST['street']),
                'longlat' => trim($_POST['longlat']),
                'typename' => trim($_POST['typename']),
                'audio_time' => intval($_POST['audio_time']),
                'status' => 1,
                'addtime' => time()
        );
        if ($_FILES['thumb']['name']) { // 上传图片 同时生成两张缩略图
            $data['thumb'] = uploadFile('thumb');
            thumb2($data['thumb']);
        }
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
        }
        
        $query = $this->db->insert('fly_askway', $data);
        echo 'ok';
    }
    
    // 文字路况 删除单条
    function delete ()
    {
        $id = intval($_GET['id']);
        $uid = intval($_GET['uid']);        
        
        if ( empty($id) || empty($uid) ) {
           error(1, 'id or uid is null');
        }
        $this->db->query("DELETE FROM fly_askway WHERE id='$id' AND uid='$uid' limit 1");
        echo 'ok';       
    }
    
    // 评论列表 根据 用户ID
    function answer_list_uid ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $uid = intval($_GET['uid']);
        if ($uid) {
            exit("");
        }
    
        $offset = $page > 0 ? $page * $this->pagesize : 0;
    
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_comment WHERE uid='$uid'");
        $count_row = $query->row_array();
        $count = $count_row['num'];
    
        if ($count > $offset) {
            $sql = "SELECT id,uid,content,audio,addtime FROM fly_comment WHERE uid='$uid' ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['addtime'] = timeFromNow($row['addtime']);
                $data[] = $row;
            }
        }
    
        // print_r($data);
        echo json_encode($data);
    } 
    
    
    // 回答信息 列表 根据 问题id  
    function answer_list_askid ()
    {
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $askid = intval($_GET['askid']);
        if (empty($askid)) {
           error(1,'askid is null');
        }
    
        $offset = $page > 0 ? $page * 10 : 0;
    
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_askway_answer WHERE askway_id='$askid'");
        $count_row = $query->row_array();
        $count = $count_row['num'];
    
        if ($count > $offset) {
            $sql = "SELECT id,uid,content,audio,audio_time,addtime FROM fly_askway_answer WHERE askway_id='$askid' ORDER BY id DESC limit $offset,10";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['addtime'] = timeFromNow($row['addtime']);
                $data[] = $row;
            }
            $data = addMember($data);
        }
    
        // print_r($data);
        echo json_encode($data);
    }
    
    // 问路 回答信息 保存 接口
    function answer_save ()
    {
        $data = array(
                'uid' => intval($_POST['uid']),
                'askway_id' => intval($_POST['askway_id']),
                'content' => trim($_POST['content']),
                'audio_time' => intval($_POST['audio_time']),
                'addtime' => time()
        );
        if (empty($data['askway_id'])) {
            error(1, "askway_id is null");
        }
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
        }               
        
        $query = $this->db->insert('fly_askway_answer', $data);
        
        // 评论数加1
        $this->db->query(
                "update fly_askway set comments=comments+1 where id=$data[askway_id] limit 1");
         echo 'ok';
    }
    
    
    
    
} // 类结束

