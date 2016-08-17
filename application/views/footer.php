
<div class="link">
	<div class="link_title">友情链接</div>
    <div class="link_con">
    <?php 
		$this->db->order_by("id", "desc");
		$query_top = $this->db->get_where('fm_link', array());
		$list = $query_top->result_array();
		foreach($list as $r){
		?>
    <a href="<?=$r['url']?>"><?=$r['name']?></a> 
	<?php }?>
    </div>
</div>
<div class="footer">
    <div class="fmain">
        <div class="copyright">
          <p>版权所有 2004-2014 未经广西人民广播电台 同意请勿转载</p>
          <p> 信息网络传播视听节目许可证号:2005125　桂ICP备05004840</p>
          <p> 广西网警备案号：45010302000046　互联网新闻信息服务备案许可证：4510020100001</p>
          <p> Copyright © 2009-2014 GuangXi people's Broadcasting Station, All Rights Reserved </p>
        </div>
        <div class="about">
          <div class="ftitle">&nbsp;&nbsp;关于我们</div>
            <p><img src="static/images/about.png" usemap="#Map" border="0" />
              <map name="Map" id="Map">
                <area shape="rect" coords="2,7,50,80" href="#" />
                <area shape="rect" coords="64,7,110,80" href="#" />
                <area shape="rect" coords="125,7,170,80" href="#" />
                <area shape="rect" coords="184,7,230,80" href="#" />
              </map>
            </p>
        </div>
        <!--<div class="service">
          <div class="ftitle">客服中心</div>
            <p>400-8888-910</p>
          <div class="ftitle">客服邮箱</div>
            <p>4008888910@nawaa.com</p>
        </div>-->
    </div>
</div>
</body>
</html>
