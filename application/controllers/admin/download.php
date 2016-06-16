<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class download extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'download';
        $this->baseurl = 'index.php?d=admin&c=download';
        $this->table = 'fm_download';
        $this->list_view = 'download_list';
        $this->add_view = 'download_add';
    }
    
    // 首页
    public function index ()
    {
        $data['list'] = array(
							0=>array('id'=>0,'name'=>'QuickTimeInstaller.exe')
		);
        $this->load->view('admin/' . $this->list_view, $data);
    }
    
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        
       
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $query = $this->db->update($this->table, $data);
			adminlog('修改信息: '.$this->control.' -> '.$id);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $query = $this->db->insert($this->table, $data);
			adminlog('添加信息: '.$this->control.' -> '.$this->db->insert_id());
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
    }
    
	public function downloads(){
		ob_clean();
		$id = $_GET['id']; 
		$fileArr = array("./download/QuickTimeInstaller.exe");
		$file = $fileArr[$id];
		$filenames = explode("/", $file);
		$filename = $filenames[2];var_dump($filename);var_dump($file);
		if(file_exists($file)){ 
			/*//文件的类型  
			header("Content-type: application/octet-stream");  
			//下载显示的名字  
			header("Content-Disposition: attachment; filename=".$filename);  
			readfile($file);  */
			$this->load->helper('download');
			$data = file_get_contents($file); // 读文件内容			
			force_download($filename, $data); 
			}else{  
				echo "文件不存在";  
			}  		
		
	}
   
}
