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

    public function getApk() {
        header("location: cmradio.apk");
    }

}