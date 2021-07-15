// 启动material
$.material.init();

// 语言切换，只在enable类跳转
$('.language:not(.enable)').click((e) => e.preventDefault())

// edite是包含在iframe中的，一旦加载则重置其高度
zEvent.on("resize-edite", (data) => {
    $('iframe.edite').each(function() {
        var documentHeight = $(this).contents().find('html').height('auto').height();
        $(this).height(documentHeight+20)
    })
})

// 侧边栏控制
// 侧边栏初始化
$(".categray-wrapper .item.active").parents(".categray").addClass("active open")
if ($('.items .categray').length) {
    $('.sidebar').css({ "width": "170px" })
    $('.sidebar .item').css({ "padding-left": "1em" })
    $('.sidebar .items .categray p').css({ "padding-left": "1em" })
    $('.sidebar .items .categray .categray-wrapper .item').css({ "padding-left": "2em" })
}
$(".categray p").click(function () {
    $(this).parent().toggleClass("open")
    if ($('.sidebar-right').innerHeight() > ($('.sidebar').innerHeight() + 120)) {
        $('.sidebar-left').css('height', $('.sidebar-right').innerHeight())
    } else {
        $('.sidebar-left').css('height', $('.sidebar').innerHeight() + 120)
    }
    if (window.location.pathname.indexOf('fund') !== -1 && (window.screen.width) <= 1024) {
        $('.sidebar-left').css('height', $('.sidebar').innerHeight() + 20)

    }
})
// 侧边栏点击
$(".sidebar .item").click(function() {
    var href = $(this).find("a").attr('href')
    window.location = href
})
//
$(".sidebar .item a").click((e) => e.stopPropagation())

// 监听公司公告类的Modal的已读事件
$('[data-toggle="notify"]').modal('show')
$("body").on("hidden.bs.modal", '[data-toggle="notify"]', function() {
    var id = $(this).attr('id')
    $.ajax("/site/set-read?id=" + id)
})

// portrait位置更改
// 如果屏幕尺寸小于768，将其置于.navbar .navbar-header顶部
// 如果屏幕尺寸大于768，将其置于#navigation .nav尾部
$(document).ready(changePortrait)
$(window).resize(changePortrait)

function changePortrait() {
    // 清楚原有
    $('[id=portrait]').parent(':not(#portrait-template)').find('[id=portrait]').remove()
    var $portrait = $($('#portrait-template').html()).popover({
        placement: "bottom",
        html: true,
        content: $('#portrait-items').html(),
        template: '<div class="popover" role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
    })
    if (window.screen.width > 768) {
        $('#navigation .nav').append($portrait)
    } else {
        $('.navbar .navbar-header').prepend($portrait)
    }
}

$('#navigation').on('show.bs.collapse', function () {
    $('.navbar.navbar-transparent').css('background-color', 'rgb(8, 0, 88)')
}).on('hidden.bs.collapse', function () {
    setTimeout(function () {
        $('.navbar.navbar-transparent').css('background-color', 'transparent')
    }, 0)
})

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

//侧边栏固定
$(document).ready(function(){
    
            if(window.location.pathname.indexOf('/fund/')!==-1&&((window.screen.width)<=1024)){
                $(".sidebar-left").removeClass('hidden-xs').css({"width":"100%"})
                $(".sidebar").css({"width":"100%","position":"relative","top":"","bottom":"","margin-top":'10px'})
                $('.sidebar-left').css('height', $('.sidebar').innerHeight()+20)
                console.log("remove")
                
            }else{
                if($('.sidebar-right').innerHeight()>($('.sidebar').innerHeight()+120)){
                    $('.sidebar-left').css('height', $('.sidebar-right').innerHeight())
                }else{
                    $('.sidebar-left').css('height', $('.sidebar').innerHeight()+120)
                }
            }  
	$(window).scroll(function(){
        var topp = $(document).scrollTop();
        var left=topp+$('.sidebar').innerHeight()+100
        var right=$('.sidebar-right').offset().top+$('.sidebar-right').innerHeight()
        //console.log($('.sidebar').innerHeight(),left,right)
        if($(".sidebar")&&topp>250){
            if(left<=right){
                $(".sidebar").css({"position":"fixed","top":"0px","bottom":""});
            }else{
                $(".sidebar").css({"position":"relative","top":($('.sidebar-right').innerHeight()-$('.sidebar').innerHeight()-110)+"px","bottom":""});
            }
        }
        if($(".sidebar")&&topp<=250){
            $(".sidebar").css({"position":"relative","top":"","bottom":""});
        }
        
        if((window.location.pathname.indexOf('/fund/')!==-1)&&(window.screen.width)<=1024){
            $(".sidebar-left").removeClass('hidden-xs').css({"width":"100%"})
            $(".sidebar").css({"width":"100%","position":"relative","top":"","bottom":"","margin-top":'10px'})
        }
    })
})
