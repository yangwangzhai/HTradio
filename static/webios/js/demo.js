$(function () {
    'use strict';
    //操作表
    $(document).on("pageInit", "#creat_programme", function(e, id, page) {
        $(page).on('click','.creat_programme_li', function () {
           var id = $(this).attr("data-id");
           var ids = $("#ids").val();
           var mid = $("#mid").val();
           var title = $("#search").val();
           // alert(ids);
           window.location.href="index.php?d=webios&c=webios&m=creat_programme_detail&id="+id+"&ids="+ids+"&title="+title+"&mid="+mid;
        });
    });

    $(document).on("pageInit", "#check_box", function(e, id, page) {
        $(page).on('click','#btn_creat', function () {
            //选择的个数
            var len = $("input[type='checkbox']:checked").length;
            var ids= $("#ids").val();
            var mid= $("#mid").val();
            var title= $("#search").val();
            $('input[name="my-radio"]:checked').each(function(){
                ids +=$(this).val()+",";
            });
            //alert(ids);
            window.location.href="index.php?d=webios&c=webios&m=creat_programme_process&len="+len+"&ids="+ids+"&title="+title+"&mid="+mid;
        });

    });

    $(document).on("pageInit", "#col_programme", function(e, id, page) {
        $(page).on('click','#btn_col', function () {
            //选择的个数
            var ids= '';
            var mid = $("#mid").val() ;
            $('input[name="my-radio"]:checked').each(function(){
                ids +=$(this).val()+",";
            });
            //alert(ids);
            window.location.href="index.php?d=webios&c=webios&m=save_col_programme&mid="+mid+"&ids="+ids;
        });

    });



    $.init();
});