<?php
class Qqlogin extends CI_Controller
{
	
	
	 function __construct ()
    {
        parent::__construct();


		
		}
	 public function index ()
    {        
require_once("qqConnectAPI.php");
$qc = new QC();
$qc->qq_login();

   
}






}