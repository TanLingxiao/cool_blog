$(document).ready(function($) {
    // 利用 data-scroll 属性，滚动到任意 dom 元素
    $.scrollto = function(scrolldom, scrolltime) {	
        $(scrolldom).click( function(){ 
            var scrolltodom = $(this).attr("data-scroll");
            $(this).addClass("active").siblings().removeClass("active");
            $('html, body').animate({
                scrollTop: $(scrolltodom).offset().top
            }, scrolltime);
            return false;
        }); 		
    };
    // 判断位置控制 返回顶部的显隐
    $(window).scroll(function() {
        if ($(window).scrollTop() > 700) {
            $("#back-to-top").fadeIn(800);
        } else {
            $("#back-to-top").fadeOut(800);
        }
    });
    // 启用
    $.scrollto("#back-to-top", 800);
 
    // 新窗口打开链接
    //$(".post a").attr("target", "_blank");

    // Ctrl + Enter 提交回复
    $('#comment-content').keydown(function(event) { 
        if (event.ctrlKey && event.keyCode == 13) {
            $('#comment-submit').click();
            return false;
        }
    });

    // 点击标签 收起/展开 内容
    $('.side .block .label').click(function () {
        $(this).siblings('.list').slideToggle("slow");
    });
    $('.main .block .comments').click(function () {
        $(this).siblings('.comment-list').slideToggle("slow");
    });
    $('.main .block .round-date').click(function () {
        $(this).siblings('.label').slideToggle("slow");
        $(this).siblings('.article-content').slideToggle("slow");
    });

    // 异步评论翻页
    // 暂未完成
    var ajaxed = false;
    $('#comments').on("click", ".page-navigator li a", function(e) {
        e.preventDefault();

        if ($(this).parent().hasClass('current') || ajaxed == true)
            return; 
        url = $(this).attr("href").replace("#comments", "") + "?action=ajax_comments";

        $.ajax({ 
           url: url,
           beforeSend: function() {
               $('#comments .comment-list').html('<p class="waiting">正在努力加载内容, 请稍等...</p>');
               ajaxed = true;
           },
           success: function(data) {
               $('#comments').html(data);
               $.scrollto('#comments', 500);
               ajaxed = false;
           }
        });
        return false;
    });

    //边栏固定
    var $sidebar = $("#fixed"),
        $fixside = $('.fixsidebar'),
     $window = $(window),
     offset = $sidebar.offset(),
     widths=$sidebar.width();
     if($window.width() > 768){
        $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
                var widths=$sidebar.width();
                $fixside.addClass('fix').css("width",widths);
                $fixside.stop().animate({top:'70px'});
            } else {
                $fixside.stop().animate({top:'-400px'});
            $fixside.removeClass('fix');
            }    
        });    
    }
});


$(function(){
     highLight();
    //面包屑导航展开
    $("#btn-col").click(function(){
        $(".nav-collapse").toggle();

        //alert("11");
    });
     $(window).resize(function(){
         if($(window).width()>=768)
        $(".nav-collapse").css("display","none");
      highLight();
     });
       //高亮显示
     function highLight(){
      if($(window).width()<=768)
           {
             $(".container-fluid .nav li").hover(function(){
                    $(this).addClass("highlight");
             },function(){
                    $(this).removeClass("highlight");
         });
       }
     };
 
   
});
    

