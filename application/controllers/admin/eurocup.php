<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

//节目单管理  控制器

include 'content.php';

class eurocup extends Content
{
    function __construct ()
    {
        parent::__construct();

        $this->control = 'eurocup';
        $this->baseurl = 'index.php?d=admin&c=eurocup';
        $this->table = 'fm_eurocup';
        $this->list_view = 'eurocup_list';
        $this->add_view = 'programme_add';
    }

    public function index(){

    }














}