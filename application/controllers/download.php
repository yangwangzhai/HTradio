<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
   
class Download extends CI_Controller
{
	 function __construct ()
    {
        parent::__construct();
		
	}
    // 首页
    public function index ()
    {
    	$this->load->view("download");
    }

    public function tbApk(){
        $this->load->view("tongbuApk");
    }

    public function getApk() {
        header("location: cmradio.apk");
    }

    public function getTbApk(){
        header("location: haitun.apk");
    }

    public function getTbApk2(){
        header("location: haitun-pad.apk");
    }

}