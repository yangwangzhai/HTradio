<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');


class Index extends CI_Controller
{
	 function __construct ()
    {
        parent::__construct();
		
	}
    // 首页
    public function index ()
    {
require_once("/qqAPI/qqConnectAPI.php");
$qc = new QC();
$qc->qq_login();
	}
}