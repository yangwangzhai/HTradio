<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 友情链接和广告 控制器 by tangjian 

include 'content.php';

class Ad extends Content
{

    function __construct ()
    {
        parent::__construct();
        
        $this->control = 'ad';
        $this->baseurl = 'index.php?d=admin&c=ad';
        $this->table = 'fm_ad';
    }
}
