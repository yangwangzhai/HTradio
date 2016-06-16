<?php $this->load->view('admin/header');?>
<script>
/* 下面的代码为内容页value04.html页面里的代码，请自行打开此文件查看代码 */
var api = frameElement.api, W = api.opener;
$(document).ready(function(){
    $("a").click(function(){   
        
    	W.document.getElementById(api.data+'id').value = $(this).attr('title'); 	
    	W.document.getElementById(api.data).value = $(this).text();
    	api.close();
    });
});
</script>

<ul class="citys">
    <?=$html?>
</ul>

<?php $this->load->view('admin/footer');?>