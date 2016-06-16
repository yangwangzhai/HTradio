<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 统计 控制器 by tangjian

include 'content.php';

class stat extends Content
{    
    function __construct ()
    {
        parent::__construct();
        $this->control = 'stat';
        $this->baseurl = 'index.php?d=admin&c=stat';
        $this->table = 'fm_stat';
        $this->list_view = 'stat_list'; // 添加页

        
    }
    
	
	  // 首页
    public function index ()
    {        
        $searchsql = '';
       
        $catid = intval($_REQUEST['catid']);
        $keywords = trim($_REQUEST['keywords']);
        
        if ($catid) {
            $this->baseurl .= "&catid=$catid";
            $searchsql .= " AND catid='$catid' ";
        }
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND ( phone_model like '%{$keywords}%' OR phone_brand like '%{$keywords}%' OR city like '%{$keywords}%'   )";
        }
        
        $data['list'] = array();
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM $this->table WHERE 1 $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        
        $this->config->load('pagination', TRUE);       
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count['num'];        
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();
                
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;       
        $sql = "SELECT * FROM $this->table WHERE 1 $searchsql ORDER BY id desc limit $offset,$this->per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $data['catid'] = $catid;
        
        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
	
	//访问量统计
    public function PV()
    {
        $data['select'] = array('day'=>'按日统计','month'=>'按月统计','quarter'=>'按季统计','year'=>'按年统计'); 
        $data['key'] = $_GET['key'];
        $data['total'] = 0;
        $year = strtotime(date('Y-1-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $month = strtotime(date('Y-m-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $day = strtotime(!empty($_GET['date'])?$_GET['date']:date('Y-m-d'));

        //按日统计
        if(!isset($_GET['key']) || $_GET['key'] == 'day')
        {
            $data['categories'] = array('0点','1点','2点','3点','4点','5点','6点','7点','8点','9点','10点','11点','12点','13点','14点','15点','16点','17点','18点','19点','20点','21点','22点','23点');
            $query = $this->db->query("select count(*) num,HOUR(FROM_UNIXTIME(addtime)) hours from fm_stat where addtime>=".$day." AND addtime<=".$day."+86400 group by HOUR(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();
            $hours = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0,13=>0,14=>0,15=>0,16=>0,17=>0,18=>0,19=>0,20=>0,21=>0,22=>0,23=>0);
            foreach ($result as $val) {
                $hours[$val['hours']] = intval($val['num']);
                $data['total'] += intval($val['num']);
            }
            $data['date'] = $day;
            $data['subtitle'] = date('Y年m月d日',$day);
            $data['list'] = $hours;

            $this->load->view('stat/day_view', $data);
        }

        //按月统计
        if($_GET['key'] == 'month')
        {
            $days = date('t',$month);
            $month_end = 86400*$days;//一个月的秒数
            for ($i=1; $i <= $days; $i++) { 
                $temp[] = $i.'日';
                $day_data[] = 0;
            }
            $data['categories'] = $temp;
            $query = $this->db->query("select count(*) num,DAYOFMONTH(FROM_UNIXTIME(addtime)) days from fm_stat where addtime>=$month AND addtime<=$month+$month_end group by DAYOFMONTH(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();
            foreach ($result as $val) {
                $day_data[intval($val['days'])-1] = intval($val['num']);
                $data['total'] += intval($val['num']);
            }
            $data['date'] = strtotime($_GET['date']);
            $data['subtitle'] = date('Y年m月',$month);
            $data['list'] = $day_data;
            $this->load->view('stat/day_view', $data);
        }

        //按季度统计
        if($_GET['key'] == 'quarter')
        {
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $day_end = 86400*$days;//一年的秒数
            for ($i=1; $i <= 4; $i++) { 
                $temp[] = '第'.$i.'季度';
            }
            $data['categories'] = $temp;
            $query = $this->db->query("select count(*) num,QUARTER(FROM_UNIXTIME(addtime)) quarter from fm_stat where addtime>=$year AND addtime<=$year+$day_end group by QUARTER(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();
            $quarter_data = array(0=>0,1=>0,2=>0,3=>0);
            foreach ($result as $val) {
                $quarter_data[intval($val['quarter'])-1] = intval($val['num']);
                $data['total'] += intval($val['num']);
            }
            $data['date'] = strtotime($_GET['date']);
            $data['subtitle'] = date('Y年季度',$year);
            $data['list'] = $quarter_data;
            $this->load->view('stat/day_view', $data);
        }

        //按年统计
        if($_GET['key'] == 'year')
        {
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $day_end = 86400*$days;//一年的秒数
            for ($i=1; $i <= 12; $i++) { 
                $temp[] = $i.'月';
                $year_data[] = 0;
            }
            $data['categories'] = $temp;
            $query = $this->db->query("select count(*) num,MONTH(FROM_UNIXTIME(addtime)) month from fm_stat where addtime>=$year AND addtime<=$year+$day_end group by MONTH(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();
            foreach ($result as $val) {
                $year_data[intval($val['month'])-1] = intval($val['num']);
                $data['total'] += intval($val['num']);
            }
            $data['date'] = strtotime($_GET['date']);
            $data['subtitle'] = date('Y年度',$year);
            $data['list'] = $year_data;
            $this->load->view('stat/day_view', $data);
        }
    }

    //客户端安装量统计
    public function Installs()
    {
        $data['select'] = array('day'=>'按日统计','month'=>'按月统计','quarter'=>'按季统计','year'=>'按年统计'); 
        $data['key'] = $_GET['key'];
        $data['total'] = 0;
        $year = strtotime(date('Y-1-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $month = strtotime(date('Y-m-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $day = strtotime(!empty($_GET['date'])?$_GET['date']:date('Y-m-d'));

        //按日统计
        if(!isset($_GET['key']) || $_GET['key'] == 'day')
        {
            $data['categories'] = array('0点','1点','2点','3点','4点','5点','6点','7点','8点','9点','10点','11点','12点','13点','14点','15点','16点','17点','18点','19点','20点','21点','22点','23点');
            $query = $this->db->query("select count(*) num,HOUR(FROM_UNIXTIME(addtime)) hours,phone_os from fm_stat where isfirst=1 AND addtime>=$day AND addtime<=$day+86400 group by phone_os,HOUR(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();

            $android = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0,13=>0,14=>0,15=>0,16=>0,17=>0,18=>0,19=>0,20=>0,21=>0,22=>0,23=>0);
            $ios = array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0,13=>0,14=>0,15=>0,16=>0,17=>0,18=>0,19=>0,20=>0,21=>0,22=>0,23=>0);
            foreach ($result as $val) {
                if($val['phone_os'] == '1')
                {
                    $android[$val['hours']] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }elseif ($val['phone_os'] == '2') {
                    $ios[$val['hours']] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }
                
            }
            $data['date'] = $day;
            $data['subtitle'] = date('Y年m月d日',$day);
            $data['list']['android'] = $android;
            $data['list']['ios'] = $ios;
            $this->load->view('stat/installs', $data);
        }

        //按月统计
        if($_GET['key'] == 'month')
        {
            $days = date('t',$month);
            $month_end = 86400*$days;//一个月的秒数
            for ($i=1; $i <= $days; $i++) { 
                $temp[] = $i.'日';
                $android[] = 0;
                $ios[] = 0;
            }
            $data['categories'] = $temp;
            $query = $this->db->query("select count(*) num,DAYOFMONTH(FROM_UNIXTIME(addtime)) days,phone_os from fm_stat where isfirst=1 AND addtime>=$month AND addtime<=$month+$month_end group by phone_os,DAYOFMONTH(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();

            foreach ($result as $val) {
                if($val['phone_os'] == '1')
                {
                    $android[$val['days']-1] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }elseif ($val['phone_os'] == '2') {
                    $ios[$val['days']-1] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }
            }
            $data['date'] = strtotime($_GET['date']);
            $data['subtitle'] = date('Y年m月',$month);
            $data['list']['android'] = $android;
            $data['list']['ios'] = $ios;

            $this->load->view('stat/installs', $data);
        }

        //按季度统计
        if($_GET['key'] == 'quarter')
        {
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $day_end = 86400*$days;//一年的秒数
            for ($i=1; $i <= 4; $i++) { 
                $temp[] = '第'.$i.'季度';
            }
            $data['categories'] = $temp;
            $query = $this->db->query("select count(*) num,QUARTER(FROM_UNIXTIME(addtime)) quarter,phone_os from fm_stat where isfirst='1' AND addtime>=$year AND addtime<=$year+$day_end group by phone_os,QUARTER(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();
            $android = array(0=>0,1=>0,2=>0,3=>0);
            $ios = array(0=>0,1=>0,2=>0,3=>0);
            foreach ($result as $val) {
                if($val['phone_os'] == '1')
                {
                    $android[$val['quarter']-1] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }elseif ($val['phone_os'] == '2') {
                    $ios[$val['quarter']-1] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }
            }
            $data['date'] = strtotime($_GET['date']);
            $data['subtitle'] = date('Y年季度',$year);
            $data['list']['android'] = $android;
            $data['list']['ios'] = $ios;
            $this->load->view('stat/installs', $data);
        }

        //按年统计
        if($_GET['key'] == 'year')
        {
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $day_end = 86400*$days;//一年的秒数
            for ($i=1; $i <= 12; $i++) { 
                $temp[] = $i.'月';
                $android[] = 0;
                $ios[] = 0;
            }
            $data['categories'] = $temp;
            $query = $this->db->query("select count(*) num,MONTH(FROM_UNIXTIME(addtime)) month,phone_os from fm_stat where isfirst='1' AND addtime>=$year AND addtime<=$year+$day_end group by phone_os,MONTH(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();
            foreach ($result as $val) {
                if($val['phone_os'] == '1')
                {
                    $android[$val['month']-1] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }elseif ($val['phone_os'] == '2') {
                    $ios[$val['month']-1] = intval($val['num']);
                    $data['total'] += intval($val['num']);
                }
            }
            $data['date'] = strtotime($_GET['date']);
            $data['subtitle'] = date('Y年度',$year);
            $data['list']['android'] = $android;
            $data['list']['ios'] = $ios;

            $this->load->view('stat/installs', $data);
        }
    }

    //资源分类统计
    public function res_type()
    {
        $data['select'] = array('day'=>'按日统计','month'=>'按月统计','quarter'=>'按季统计','year'=>'按年统计'); 
        $data['key'] = $_GET['key'];
        $data['total'] = 0;
        $year = strtotime(date('Y-1-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $month = strtotime(date('Y-m-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $day = strtotime(date('Y-m-d',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        if ($_GET['key'] == 'quarter') {//按季度统计则定义name属性
            $data['num'][] = array('name'=>'第一季','data'=>'');
            $data['num'][] = array('name'=>'第二季','data'=>'');
            $data['num'][] = array('name'=>'第三季','data'=>'');
            $data['num'][] = array('name'=>'第四季','data'=>'');
        }
            

        //获取所有分类
        $query = $this->db->query("select title from fm_program_type");
        foreach ($query->result_array() as $val) {
            $data['categories'][] = $val[title];
            if($_GET['key'] == 'quarter'){
                $data['num'][0]['data'][] = 0;
                $data['num'][1]['data'][] = 0;
                $data['num'][2]['data'][] = 0;
                $data['num'][3]['data'][] = 0;
            }else{
                $data['num'][0]['data'][] = 0;
            }
        }
        
        //按日统计
        if(!isset($_GET['key']) || $_GET['key'] == 'day')
        {
            $query = $this->db->query("select count(*) num,type_id from fm_program where addtime>=$day AND addtime<=$day+86400 group by type_id");
            $result = $query->result_array();

            $data['subtitle'] = date('Y年m月d日',$day);
        }

        //按月统计
        if($_GET['key'] == 'month')
        {
            $days = date('t',$month);
            $month_end = 86400*$days;//一个月的秒数
            $query = $this->db->query("select count(*) num,type_id from fm_program where addtime>=$month AND addtime<=$month+$month_end group by type_id");
            $result = $query->result_array();
            $data['subtitle'] = date('Y年m月',$month);
        }

        //按季度统计
        if($_GET['key'] == 'quarter')
        {
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $day_end = 86400*$days;//一年的秒数
            $query = $this->db->query("select count(*) num,type_id,QUARTER(FROM_UNIXTIME(addtime)) quarter from fm_program where addtime>=$year AND addtime<=$year+$day_end group by type_id,QUARTER(FROM_UNIXTIME(addtime))");
            $result = $query->result_array();
            $data['subtitle'] = date('Y年季度',$year);
        }

        //按年统计
        if($_GET['key'] == 'year')
        {
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $day_end = 86400*$days;//一年的秒数
            $query = $this->db->query("select count(*) num,type_id from fm_program where addtime>=$year AND addtime<=$year+$day_end group by type_id");
            $result = $query->result_array();
            $data['subtitle'] = date('Y年度',$year);
        }
        foreach ($result as $val) {
            $cate_key = array_search(getProgramTypeName($val['type_id']),$data['categories']);
            if ($_GET['key'] == 'quarter') {//按季度统计则每个分类有四条柱形图
                switch ($val['quarter']) {
                    case '1':
                        $data['num'][0]['data'][$cate_key] = intval($val['num']);
                        $data['total'] += intval($val['num']);
                        break;
                    case '2':
                        $data['num'][1]['data'][$cate_key] = intval($val['num']);
                        $data['total'] += intval($val['num']);
                        break;
                    case '3':
                        $data['num'][2]['data'][$cate_key] = intval($val['num']);
                        $data['total'] += intval($val['num']);
                        break;
                    case '4':
                        $data['num'][3]['data'][$cate_key] = intval($val['num']);
                        $data['total'] += intval($val['num']);
                        break;
                }
            }else {
                $data['num'][0]['data'][$cate_key] = intval($val['num']);
                $data['total'] += intval($val['num']);
            }
        }
        $data['date'] = strtotime($_GET['date']?$_GET['date']:date('Y-m-d',time()));
        $this->load->view('stat/res_type', $data);
    }

    //节目统计
    public function program_stat()
    {
        $data['select'] = array('day'=>'按日统计','month'=>'按月统计','quarter'=>'按季统计','year'=>'按年统计'); 
        $data['key'] = $_GET['key'];
        $year = strtotime(date('Y-1-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $month = strtotime(date('Y-m-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $day = strtotime(date('Y-m-d',!empty($_GET['date'])?strtotime($_GET['date']):time()));

        if (!isset($_GET['key']) || $_GET['key'] == 'day') {
            $time_start = $day;
            $time_end = $day+86400;
        }elseif ($_GET['key'] == 'month') {
            $time_start = $month;
            $days = date('t',$month);
            $time_end = $month+(86400*$days);
        }elseif ($_GET['key'] == 'quarter') {
            $season = ceil((date('n',$day))/3);//当月是第几季度
            $time_start =  mktime(0, 0, 0,$season*3-3+1,1,date('Y',$day));
            $time_end = mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y",$day))),date('Y',$day));
        }elseif ($_GET['key'] == 'year') {
            $time_start = $year;
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $time_end = $year+(86400*$days);
        }

        $query = $this->db->query("select title,playtimes from fm_program where status=1 AND addtime>=$time_start AND addtime<=$time_end ORDER BY playtimes desc limit 20");
        $list = $query->result_array();
        $data['categories'] = array();
        $data['num'] = array();
        $data['total'] = 0;
        foreach ($list as $k => $v) {
            $data['categories'][] = $v['title'];
            $data['num'][0]['data'][] = intval($v['playtimes']);
            $data['total'] += 1;
        }
        $data['subtitle'] = date('Y年m月d日',$day);
        $data['date'] = $day;
        $this->load->view('stat/program_stat',$data);
    }

    //主持人/用户人气统计
    public function renqi_stat()
    {
        $type = array(0 => '用户',1 => '主持');

        if(!isset($_GET['type']) || ($_GET['type'] != 0 && $_GET['type'] != 1))
        {
            show('0','请求参数不正确');
        }

        $data['select'] = array('day'=>'按日统计','month'=>'按月统计','quarter'=>'按季统计','year'=>'按年统计'); 
        $data['key'] = $_GET['key'];
        $year = strtotime(date('Y-1-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $month = strtotime(date('Y-m-1',!empty($_GET['date'])?strtotime($_GET['date']):time()));
        $day = strtotime(date('Y-m-d',!empty($_GET['date'])?strtotime($_GET['date']):time()));

        if (!isset($_GET['key']) || $_GET['key'] == 'day') {
            $time_start = $day;
            $time_end = $day+86400;
        }elseif ($_GET['key'] == 'month') {
            $time_start = $month;
            $days = date('t',$month);
            $time_end = $month+(86400*$days);
        }elseif ($_GET['key'] == 'quarter') {
            $season = ceil((date('n',$day))/3);//当月是第几季度
            $time_start =  mktime(0, 0, 0,$season*3-3+1,1,date('Y',$day));
            $time_end = mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y",$day))),date('Y',$day));
        }elseif ($_GET['key'] == 'year') {
            $time_start = $year;
            $isleapyear = date('L',$year);//是否为润年
            $days = $isleapyear?366:365;//润年366天，非润年365天
            $time_end = $year+(86400*$days);
        }

        //获取主持人人气列表
        $list = $this->db->query("select count(*) num,zid from fm_attention WHERE is_zcr={$_GET['type']} AND addtime>=$time_start AND addtime<=$time_end group by zid");
        $rq = $list->result_array();
        //获取主持人信息
        $query = $this->db->query("select id,username,nickname from fm_member WHERE type={$_GET['type']} ORDER BY id DESC limit 20");
        $zcr = $query->result_array();

        foreach ($zcr as &$val) {
            $data['categories'][] = $val['nickname'];
            foreach ($rq as $v) {
                if($val['id'] == $v['zid']){
                    $val['num'] = $v['num'];
                    break;
                }else{
                    $val['num'] = 0;
                }
            }
            $data['num'][0]['data'][] = intval($val['num']);
        }

        $data['type'] = $_GET['type'];
        $data['subtitle'] = date('Y年m月d日',$day);
        $data['date'] = $day;

        $this->load->view('stat/renqi.php',$data);
    }

    
}
