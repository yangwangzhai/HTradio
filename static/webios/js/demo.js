$(function () {
    'use strict';
    //操作表
    $(document).on("pageInit", "#creat_programme", function(e, id, page) {
        $(page).on('click','.creat_programme_li', function () {
           var id = $(this).attr("data-id");
           var ids = $("#ids").val();
           var title = $("#search").val();
            alert(ids);
           window.location.href="index.php?d=webios&c=webios&m=creat_programme_detail&id="+id+"&ids="+ids+"&title="+title;
        });
    });

    $(document).on("pageInit", "#check_box", function(e, id, page) {
        $(page).on('click','.fbtn', function () {
            //选择的个数
            var len = $("input[type='checkbox']:checked").length;
            var ids= $("#ids").val();
            var title= $("#search").val();
            $('input[name="my-radio"]:checked').each(function(){
                ids +=$(this).val()+",";
            });
            alert(ids);
            window.location.href="index.php?d=webios&c=webios&m=creat_programme_process&len="+len+"&ids="+ids+"&title="+title;
        });

    });

    $(document).on("pageInit", "#programme_detail", function(e, id, page) {
        $(page).on('click','.play', function () {
            //跳转播放界面
            //window.location.href="index.php?d=webios&c=webios&m=creat_programme_process&len="+len+"&ids="+ids+"&title="+title;
        });

    });







    $.init();
});