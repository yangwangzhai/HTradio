<style>
.maintable {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-collapse: collapse;
    border-color: #86b9d6 #d8dde5 #d8dde5;
    border-image: none;
    border-style: solid;
    border-width: 2px 1px 1px;
    width: 100%;
}
.maintable th, .maintable td {
    border: 1px solid #d8dde5;
    padding: 5px;
	color: #666;
    font: 14px "Lucida Grande",Verdana,Lucida,Helvetica,Arial,"Simsun",sans-serif;
}
.maintable th {
    background: #f3f7ff none repeat scroll 0 0;
    color: #0d58a5;
    font-weight: normal;
    text-align: left;
    width: 210px;
}
.maintable td th, .maintable td td {
    border: medium none;
    padding: 1px;
}
.maintable th p {
    color: #909dc6;
    margin: 0;
}
.maintable td:nth-of-type(odd){ text-align:right;}

</style> 

<table width="99%" border="0" cellpadding="3" cellspacing="0"  class="maintable">	
		      <tr>
				<td  style="width:80px; text-align:right;">
                节目名称
                </td>
                <td  style="width:200px;">
                 <?=$title?>
                </td>
                
                	<td style="width: 80px; text-align:right;">
                 作者
                </td>
                <td >
                <?=getNickName($mid)?>
                </td>
			</tr>		
             <tr>
				<td>所属类型</td>
				<td><?=getProgramTypeName($type_id)?></td>
                
                <td>   收听量</td>
				<td> <?=$playtimes?></td>
			</tr>
            
          
            	
			<tr>
				<td>
               点赞次数
                </td>
                <td >
             <?=$zantimes?>
                </td>
                
                <td>
              分享次数
                </td>
                <td >
              <?=$sharetimes?>
                </td>
			</tr>			
			<tr>
				<td >
              下载次数 
                </td>
                 <td >
               <?=$downloadtimes?>
                 </td>
                 
                 <td >
             是否原创
                </td>
                 <td >
              <?=$original ==1 ?'是':'否'?>
                 </td>
			</tr>
		    <tr height="80">
				<td>
                节目描述
                </td>
                 <td colspan="3">             
              
                <?=$content?>
               
                 </td>
			</tr>
			
           
		</table>