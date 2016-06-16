<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * android客户端调用接口文件 地图及路况等数据接口 
 * code by tangjian 
 */
include 'api.php';

class Map extends Api
{

    function __construct ()
    {
        parent::__construct();
    }
    
    // 获取所有路况信息 版本
    function trafficmap_version ()
    {
        echo '0.3';
    }
    
    // 获取所有路况信息
    function trafficmap_list ()
    {
        $query = $this->db->query("select id,path from fly_trafficmap");
        $list = $query->result_array();
        echo json_encode($list);
    }
    
    // 只获取 缓行和拥堵 路段状态 格式 "1,3,34|1,2,1"
    function trafficmap_block ()
    {
        $return = '';
        $ids = $status = array();
        $query = $this->db->query(
                "select id,status from fly_trafficmap where status>0");
        foreach ($query->result_array() as $value) {
            $ids[] = $value['id'];
            $status[] = $value['status'];
        }
        $return = implode(',', $ids) . '|' . implode(',', $status);
        
        echo $return;
    }
    
    // 获取所有路况信息
    function trafficmap_one ()
    {
        $data = array();
        $id = intval($_GET['id']);
        if ($id) {
            $query = $this->db->query(
                    "select * from fly_trafficmap where id=$id limit 1");
            $data = $query->row_array();
        }
        
        echo json_encode($data);
    }
    
    // 交通事故 列表输出
    function accident_list ()
    {
        $query = $this->db->query(
                "select id,title,path from fly_singleline where status=5 order by id desc limit 20");
        $list = $query->result_array();
        echo json_encode($list);
    }
    
    // 禁左/单行线 折线 列表输出
    function singleline_list ()
    {
        $query = $this->db->query(
                "select id,title,status,path from fly_singleline where status=0");
        $list = $query->result_array();
        echo json_encode($list);
    }
    
    // 禁左/单行线 标注 列表输出
    function singlemarker_list ()
    {
        $query = $this->db->query(
                "select id,title,path,status from fly_singleline where status>=10");
        $list = $query->result_array();
        echo json_encode($list);
    }
    
    // 获取 路况的 时效，返回秒， 默认 180分钟
    function getTrafficTimeliness ()
    {
        $timeliness = 180;
        
        $set = get_cache('website');
        $temp = intval($set['traffic_time']);
        if ($temp > 0) {
            $timeliness = time() - ($temp * 60);
        }
        
        return $timeliness;
    }
    
    // 文字路况 列表 先获取路况表，如果是会员 则从会员获取数据，组合起来
    function traffictext_list ()
    {
        $timeliness = $this->getTrafficTimeliness();        
        
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
                "SELECT COUNT(*) AS num FROM fly_traffictext WHERE status=1 AND addtime>=$timeliness $sqls");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        $districts = $this->config->item('district');
        // 文字路况列表
        if ($count > $offset) {
            $sql = "SELECT id,uid,title,thumb,audio,audio_time,district,street,longlat,comments,typename,addtime FROM fly_traffictext WHERE status=1 AND addtime>=$timeliness $sqls ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['title'] = $districts[$row['district']] . ' ' .
                         $row['street'] . ' ' . $row['typename'] . ' ' .
                         $row['title'];
                $row['addtime'] = timeFromNow($row['addtime']);
                $row['thumb'] = new_thumbname($row['thumb'], 100, 100);
                $data[] = $row;
            }
            $data = addMember($data);
        }
        
        echo json_encode($data);
    }
    
    
    
    // 文字路况 列表 个人的
    function traffic_uid ()
    {
        $sqls = '';
        $data = $member = array();
        $page = intval($_GET['page']) - 1;
        $uid = intval($_GET['uid']);
        if ($uid == 0) {
            error(1, 'uid is null');
        }
        
        $sqls .= " AND uid='$uid' ";
        $offset = $page > 0 ? $page * $this->pagesize : 0;
        
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_traffictext WHERE status=1 $sqls");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        $districts = $this->config->item('district');
        // 文字路况列表
        if ($count > $offset) {
            $sql = "SELECT id,uid,title,thumb,audio,district,street,longlat,comments,typename,addtime FROM fly_traffictext WHERE status=1 $sqls ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['title'] = $districts[$row['district']] . ' ' .
                         $row['street'] . ' ' . $row['typename'] . ' ' .
                         $row['title'];
                $row['addtime'] = timeFromNow($row['addtime']);
                $row['thumb'] = new_thumbname($row['thumb'], 100, 100);
                $data[] = $row;
            }
            
            $data = addMember($data);
        }
        // print_r($data);
        echo json_encode($data);
    }
    
    // 文字路况 在地图上显示
    function traffictext_list_map ()
    {
        $timeliness = $this->getTrafficTimeliness();
        $districts = $this->config->item('district');
        
        $sql = "SELECT id,groupid,title,thumb,district,street,longlat,typename,addtime FROM fly_traffictext WHERE status=1 AND addtime>=$timeliness ORDER BY id DESC limit 10";
        $query = $this->db->query($sql);
        while ($row = $query->_fetch_assoc()) {
            $row['content'] = $row['id'] . '&&' . $districts[$row['district']] .
                     ' ' . $row['street'] . '&&' . $row['typename'] . '&&' .
                     $row['title'] . '&&' . timeFromNow($row['addtime']) . '&& ' .
                     new_thumbname($row['thumb'], 100, 100);
            $data[] = $row;
        }
        
        // print_r($data);
        echo json_encode($data);
    }
    
    // 文字路况 单条信息 包括发布会员的信息
    function traffictext_one ()
    {
        $id = intval($_GET['id']);
        
        if (! empty($id)) {
            $query = $this->db->query(
                    "SELECT * FROM fly_traffictext WHERE id={$id} LIMIT 1");
            // $query = $this->db->query("SELECT a.*,b.nickname,b.avatar FROM
            // fly_traffictext a,fly_member b WHERE a.id={$id} AND a.uid=b.id
            // LIMIT 1");
            $row = $query->row_array();
            $districts = $this->config->item('district');
            $row['title'] = $districts[$row['district']] . $row['street'] .
                     $row['typename'] . $row['title'];
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
    function traffictext_save ()
    {
        $districts = $this->config->item('district');
        $district = trim($_POST['district']);
        $district = intval(array_search($district, $districts));
        
        $data = array(
                'groupid' => intval($_POST['groupid']),
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
            $data['thumb'] = substr($data['thumb'], 0,1)=='-' ? '' : $data['thumb'];
            if ($data['thumb']) thumb2($data['thumb']);
        }
        if ($_FILES['audio']['name']) { // 上传语音
            $data['audio'] = uploadFile('audio', 'audio');
        }
        
        $query = $this->db->insert('fly_traffictext', $data);
        if ($this->db->insert_id()) {
            echo intval($this->db->insert_id());
            // 会员路况数加+1
            $this->load->model('common');
            $this->common->addTrafficCount($data['uid']);
            $this->load->model('stat_model');
            $this->stat_model->day_save('traffic_add'); // 主页访问数加1
            echo $this->db->insert_id();
        } else {
            error(99, '未知错误，添加没有成功');
        }
    }
    
    // 文字路况 删除单条
    function traffictext_delete ()
    {
        $id = intval($_GET['id']);
        $uid = intval($_GET['uid']);
        
        if ( empty($id) && empty($uid) ) {
            error(1, 'xxxx  is null');
        }
        
        $this->db->query( "DELETE FROM fly_traffictext WHERE id='$id' AND uid='$uid'");
        echo 'ok';
    }
    
    // 文字路况 未查看数
    function traffictext_noread ()
    {
        $result = 0;
        $lastime = intval($_GET['lasttime']);
        
        if ($lastime) {
            $query = $this->db->query(
                    "SELECT COUNT(*) AS total FROM fly_traffictext WHERE addtime>='$lastime'");
            $data = $query->row_array();
            $result = $data['total'];
        }
        
        echo $result;
    }
    
    // 举报
    function report_save ()
    {
        $data = array(
                'traffic_id' => intval($_POST['traffic_id']),
                'publisher' => intval($_POST['publisher']),
                'reporter' => intval($_POST['reporter']),
                'title' => trim($_POST['title']),
                'addtime' => time()
                );
        
        if ( empty($data['traffic_id']) || empty($data['publisher']) ) { 
            error(1, 'traffic_id or publisher is null');
        }
        
        $query = $this->db->update('fly_traffictext', array('report'=>1), 'id = '.$data['traffic_id']);
        $query = $this->db->insert('fly_report', $data);
        echo 'ok';        
    }
    
    // 被举报 文字路况 列表 先获取路况表，如果是会员 则从会员获取数据，组合起来
    function report_list ()
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
                "SELECT COUNT(*) AS num FROM fly_traffictext WHERE report=1 $sqls");
        $count_row = $query->row_array();
        $count = $count_row['num'];
        $districts = $this->config->item('district');
        // 文字路况列表
        if ($count > $offset) {
            $sql = "SELECT id,uid,title,thumb,audio,audio_time,district,street,longlat,comments,typename,addtime FROM fly_traffictext WHERE report=1 $sqls ORDER BY id DESC limit $offset,$this->pagesize";
            $query = $this->db->query($sql);
            while ($row = $query->_fetch_assoc()) {
                $row['title'] = $districts[$row['district']] . ' ' .
                        $row['street'] . ' ' . $row['typename'] . ' ' .
                        $row['title'];
                $row['addtime'] = timeFromNow($row['addtime']);
                $row['thumb'] = new_thumbname($row['thumb'], 100, 100);
                $data[] = $row;
            }
            $data = addMember($data);
        }
        
        echo json_encode($data);
    }
    
    // 文字路况 删除单条
    function delete_report ()
    {
        $id = intval($_GET['id']);        
        
        if ( empty($id) ) {
            error(1, 'id  is null');
        }
    
        $this->db->query( "DELETE FROM fly_traffictext WHERE id='$id' AND report=1 limit 1");
        echo 'ok';
    }
    
    
    
} // 类结束

