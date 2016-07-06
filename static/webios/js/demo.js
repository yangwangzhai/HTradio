$(function () {
    'use strict';
    //操作表
    $(document).on("pageInit", "#creat_programme", function(e, id, page) {
        $(page).on('click','.creat_programme_li', function () {
           var id = $(this).attr("data-id");
           var ids = $("#ids").val();
            alert(ids);
           window.location.href="index.php?d=webios&c=webios&m=creat_programme_detail&id="+id+"&ids="+ids;
        });
    });

    $(document).on("pageInit", "#check_box", function(e, id, page) {
        $(page).on('click','.fbtn', function () {
            //选择的个数
            var len = $("input[type='checkbox']:checked").length;
            var ids= $("#ids").val();
            $('input[name="my-radio"]:checked').each(function(){
                ids +=$(this).val()+",";
            });
            alert(ids);
            window.location.href="index.php?d=webios&c=webios&m=creat_programme_process&len="+len+"&ids="+ids;
        });

    });









    $.init();
});