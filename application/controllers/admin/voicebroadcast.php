<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

//节目管理  控制器

include 'content.php';

class voicebroadcast extends Content
{
    function __construct ()
    {
        parent::__construct();

        $this->control = 'voicebroadcast';
        $this->baseurl = 'index.php?d=admin&c=voicebroadcast';
        $this->table = 'fm_eurocup';
        $this->list_view = 'voicebroadcast_list';
        $this->add_view = 'voicebroadcast_add';
        $this->load->model('content_model');
    }

    public function index(){

        $searchsql = "1";
        $keywords = $this->input->post('keywords')?trim($this->input->post('keywords')):'';
        if ($keywords) {
            $this->baseurl .= "&keywords=" . rawurlencode($keywords);
            $searchsql .= " AND (title like '%{$keywords}%' OR content like '%{$keywords}%')";
        }

        $data['list'] = array();
        $count = $this->content_model->db_counts("fm_eurocup");
        $data['count'] = $count;

        $this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $this->baseurl;
        $pagination['total_rows'] = $count;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();

        $offset = $this->input->get('per_page')? intval($this->input->get('per_page')) : 0;
        $list = $this->content_model->get_list_table('*',"fm_eurocup",$searchsql,$offset,20);
        $data ['list']=$list;

        $_SESSION['url_forward'] = $this->baseurl . "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }





}

