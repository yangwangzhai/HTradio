<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
// 首页 by tangjian 
class Common extends CI_Controller
{
    // 首页
    public function index ()
    {        
        header('Location: index.php?c=front');
        exit;       
    }    
    
    // 验证码
    public function checkcode ()
    {
        include APPPATH . 'libraries/checkcode.class.php';
        $checkcode = new checkcode();
        $checkcode->doimage();
        $_SESSION['checkcode'] = $checkcode->get_code();
    }
    
    // 404
    public function show404 ()
    {
        show_404();
    }
    
    // 404
    function test ()
    {
     
        $query = $this->db->query(
                "SELECT COUNT(*) AS num FROM fly_traffictext WHERE 1 AND id='871'");
        
        print_r( $query->row_array() );      
    }
}
