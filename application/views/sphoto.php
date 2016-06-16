<style type="text/css">
<!--
body {
	
}
-->
</style>
<table width="0%" border="0" cellspacing="10" cellpadding="0">
  <tr>
  <?php if($src){?>
    <td style="text-align:center;">
     <img src="<?=$src?>" border="0" width="145" height="180" style="padding-right:10px;">
    <br>当前相片</td>
    <?php }?>
    <td><object  type="application/x-shockwave-flash" data="sphoto/oneEditor.swf" width="447" height="300">
<param name="movie" value="sphoto/oneEditor.swf">
<param name="FlashVars" value="saveUrl=sphoto/tosave.php&ID=<?=$id?>&imgSrc=">
<param name="quality" value="high">
<param name="menu" value="false">
<param name="bgcolor" value="#FFFFFF">
</object></td>
  </tr>
</table>


