<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>海豚电台</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="static/webios/css/sm.min.css">
    <link rel="stylesheet" href="static/webios/css/sm-extend.min.css">
    <link rel="stylesheet" href="static/webios/css/style_play.css">
    <script src="static/webios/js/jquery-1.9.1.js"></script>
</head>
<body>
<!-- page集合的容器，里面放多个平行的.page，其他.page作为内联页面由路由控制展示 -->
<div class="page-group">
    <!-- 单个page ,第一个.page默认被展示-->
    <div class="page" id="programme_detail" style="margin-top: 0.5rem;">
        <header class="bar bar-nav">
            <a class="button button-link button-nav pull-left external" href="index.php?d=webios&c=webios&m=my_programme&mid=<?=$mid?>">
                <span class="icon icon-left"></span>
                返回
            </a>
            <h1 class="title">我的节目单</h1>
            <a href="#" class="button button-link pull-right edit_btn">编辑</a>
        </header>
        <!-- 这里是页面内容区 -->
        <form method="post" action="index.php?d=webios&c=webios&m=program_del">
            <input type="hidden" name="programme_id" value="<?=$programme_id?>">
            <input type="hidden" name="mid" value="<?=$mid?>">
            <div class="content" style="margin-top: 2.5rem;">
            <div class="card facebook-card">
                <div class="card-header">
                    <div class="facebook-avatar"><img src="<?=$avatar?>" style='width: 2rem; height:2rem'></div>
                    <div class="facebook-name"><?=$programme_title;?></div>
                    <div class="facebook-date"><?=$username;?></div>
                </div>
                <div class="card-footer">
                    <a href="#" class="link">收藏次数<?=$col_num;?></a>
                    <a href="index.php?d=webios&c=webios&m=my_comment_view&programme_id=<?=$programme_id?>&mid=<?=$mid?>" class="link">评论次数<?=$con_num;?></a>
                    <a href="#" class="link" style="visibility:hidden;">分享 7</a>
                    <a href="#" class="link" style="visibility:hidden;">下载 5</a>
                    <!--<div class="bdsharebuttonbox">
                        <a href="#" class="bds_more link" data-cmd="more" style="background-image: none;">分享 7</a>
                    </div>
                    <a href="#" class="link">下载 5</a>-->
                </div>
            </div>
            <?php foreach($program_list as $value) :?>
            <div class="list-block media-list">
                <ul>
                    <li>
                         <a href="index.php?d=webios&c=webios&m=program_play&programme_id=<?=$programme_id?>&program_id=<?=$value['program_id']?>&mid=<?=$mid?>">
                            <label class="label-checkbox item-content">
                                <div class="item-media"><img src="static/webios/img/program_default.jpg" style='width: 2.8rem; height:2.6rem'></div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title"><?=$value['title']?></div>
                                    </div>
                                    <div class="item-subtitle">上传者：<?=$value['nickname']?> .时长：xx分钟</div>
                                </div>
                            </label>
                          </a>
                        <input type="checkbox" class="checkbox" name="delete[]" value="<?=$value['program_id']?>">
                    </li>
                </ul>
            </div>
            <?php endforeach?>
            <div class="bottom_btn">
                <a href="index.php?d=webios&c=webios&m=add_programme_view&mid=<?=$mid?>&programme_id=<?=$programme_id?>" external>
                    <div class="add_btn"></div>
                </a>
                <div class="set_btn">
                    <div class="row">
                        <div class="col-50"><a href="#" class="button button-big button-fill button-danger cancle-btn">取消</a></div>
                        <div class="col-50"><input type="submit" class="button button-big button-fill button-success" value="确定"></div>
                    </div>
                </div>
            </div>
            <script>
              $(document).ready(function () {
                  $(".edit_btn").click(function(){
                      $(".checkbox").toggle();
                      $(".set_btn").toggle();
                });
                  $(".cancle-btn").click(function(){
                      $(".checkbox").toggle();
                      $(".set_btn").toggle();
                });
                });
            </script>
            <!--<div class="bdsharebuttonbox">
                <a href="#" class="bds_more" data-cmd="more"></a>
            </div>-->
           <!-- <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
            </script>-->

        </div>
        </form>
    </div>
</div>

<script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>

<script type='text/javascript' src='static/webios/js/sm.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='static/webios/js/demo.js' charset='utf-8'></script>
</body>
</html>