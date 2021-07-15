"use strict";

/**------------------------------------------
 *       Event Handler
  ------------------------------------------*/
function ZEvent() {
    this.eventStack = {};
    this.on = function (eventName, callback) {
        this.eventStack[eventName] = callback;
    };
    this.trigger = function (eventName, event) {
        if (typeof this.eventStack[eventName] == "function") {
            this.eventStack[eventName](event.detail);
        }
    };
    this.emit = function (eventName, data) {
        if (!data) data = {};
        data["source"] = window.frameElement ? "#" + window.frameElement.id : null;
        data["eventName"] = eventName;
        var event = new CustomEvent('ZEvent', { detail: data });
        window.parent.document.dispatchEvent(event);
    };
    this.transmit = function (target, eventName, data) {
        data["transmitEventName"] = eventName;
        data["transmitTarget"] = target;
        this.emit('transmit', data);
    };
}

var zEvent = new ZEvent();
window.document.addEventListener('ZEvent', function (event) {
    var eventName = event.detail.eventName;
    zEvent.trigger(eventName, event);
}, false);

// only top frame listen this event
zEvent.on('transmit', function (data) {
    var target = data["transmitTarget"];
    delete data["transmitTarget"];
    data.eventName = data.transmitEventName;
    delete data["transmitEventName"];
    var event = new CustomEvent('ZEvent', { detail: data });
    $(target).contents()[0].dispatchEvent(event);
});

zEvent.on('load', function (data) {
    if (data.target == "#modal") {
        $(data.target).parents(".modal-dialog").attr("class", "modal-dialog");
        if (data.modal_size) {
            $(data.target).parents(".modal-dialog").addClass(data.modal_size);
        }
        $(data.target).parents(".modal").modal("show").end().one('load', function () {
            zEvent.emit('resize-modal');
        });
    }
    if (data.expanded == "maintain") {} else if (data.expanded) {
        $('.main-panel').addClass('expanded');
    } else if (!data.expaned && $('.main-panel').addClass('expanded')) {
        $('.main-panel').removeClass('expanded');
    }
    if (data.model_size) {
        $("#modal").parents(".modal-dialog").src("class", "modal-dialog").addClass(data.model_size);
    }
    $(data.target).attr('src', data.url);
});

zEvent.on('resize-modal', function (data) {
    var target = data.target ? data.target : data.source;
    // 令iframe高度等于文档高度，重置body为auto的原因是因为height原为100vh
    var documentHeight = $(target).contents().find('html').height('auto').height();
    $(target).height(documentHeight);
    if (data && data.modal_size) $(target).parents(".modal-dialog").addClass(data.modal_size);
});

zEvent.on('refresh', function (data) {
    if ($(data.target).length != 0) {
        $(data.target)[0].src = $(data.target)[0].src;
    } else {
        window.location.reload();
    }
});

zEvent.on('modal-close', function (data) {
    var target = data.target ? data.target : "#dashboard-modal";
    if (data.target) {
        $(data.target).parents(".modal").modal("hide");
    } else {
        $(data.source).parents(".modal").modal("hide");
    }
});

/**
 * Listen event of swal
 * You can call this function like
 * zEvent.emit('swal', [{title: '...', text: '...', type: 'warning', confirmButtonText: 'Confirm'}])
 */
zEvent.on('swal', function (data) {
    delete data["eventName"];
    delete data["source"];

    var arguList = $.map(data, function (value, index) {
        return [value];
    });
    swal.apply(null, arguList);
});
/**------------------------------------------
 *  Dashboard Instruction handler
 ------------------------------------------*/
$("[notify]").each(function () {
    zEvent.emit("notify", {
        message: $(this).attr('message'),
        type: $(this).attr('type'),
        icon: $(this).attr('icon'),
        timer: $(this).attr('timer'),
        align: $(this).attr('align'),
        from: $(this).attr('from')
    });
});

$("[refresh]").each(function () {
    zEvent.emit("refresh", { target: $(this).data('target') });
});

$("[pjax-reload]").each(function () {
    zEvent.transmit($(this).attr('target'), "pjax-reload", {
        pjaxContainer: $(this).attr('pjaxContainer'),
        reloadUrl: $(this).attr('reloadUrl')
    });
});

$("[modal-close]").each(function () {
    zEvent.emit("modal-close", {});
});

/**------------------------------------------
 *  兼容性
 ------------------------------------------*/
$('[modernizr-svg="' + (!Modernizr.svg).toString() + '"]').hide();
var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE");

if (msie > 0 && msie <= 8) {
    $('.container:not(footer .container) > .col-md-2 > .sidebar').parent().css({ "margin-left": "5%", "width": "11.67%", "float": "left" });
    $('.container:not(footer .container) > .col-md-10').css({ "width": "83.33%", "float": "left" });
    $('.container:not(footer .container) > .col-md-9').css({ "width": "75%", "float": "left" });
    $('footer, footer > .container, footer > .col-md-12').css({ "width": "100%" });
    $('footer .container > .col-md-6').css({ "width": "50%", "float": "left" });
    if (window.location.pathname == "/company/index") {
        $(".party-photo.col-sm-6").css({ "width": "50%", "float": "left" });
    }
    if (window.location.pathname == "/news/index") {
        $(".news-list").css({ "width": "100%", "float": "left" });
        $(".news-list .col-sm-4").css({ "width": "33.33%", "float": "left" });
    }
}

if (!Modernizr.input.placeholder) {
    $('.input-group label').show();
}
// 启动material
$.material.init();

// 语言切换，只在enable类跳转
$('.language:not(.enable)').click(function (e) {
    return e.preventDefault();
});

// edite是包含在iframe中的，一旦加载则重置其高度
zEvent.on("resize-edite", function (data) {
    $('iframe.edite').each(function () {
        var documentHeight = $(this).contents().find('html').height('auto').height();
        $(this).height(documentHeight + 20);
    });
});

// 侧边栏控制
// 侧边栏初始化
$(".categray-wrapper .item.active").parents(".categray").addClass("active open");
if ($('.items .categray').length) {
    $('.sidebar').css({ "width": "170px" });
    $('.sidebar .item').css({ "padding-left": "1em" });
    $('.sidebar .items .categray p').css({ "padding-left": "1em" });
    $('.sidebar .items .categray .categray-wrapper .item').css({ "padding-left": "2em" });
}
$(".categray p").click(function () {
    $(this).parent().toggleClass("open");
    if ($('.sidebar-right').innerHeight() > $('.sidebar').innerHeight() + 120) {
        $('.sidebar-left').css('height', $('.sidebar-right').innerHeight());
    } else {
        $('.sidebar-left').css('height', $('.sidebar').innerHeight() + 120);
    }
    if (window.location.pathname.indexOf('fund') !== -1 && window.screen.width <= 1024) {
        $('.sidebar-left').css('height', $('.sidebar').innerHeight() + 20);
    }
});
// 侧边栏点击
$(".sidebar .item").click(function () {
    var href = $(this).find("a").attr('href');
    window.location = href;
});
//
$(".sidebar .item a").click(function (e) {
    return e.stopPropagation();
});

// 监听公司公告类的Modal的已读事件
$('[data-toggle="notify"]').modal('show');
$("body").on("hidden.bs.modal", '[data-toggle="notify"]', function () {
    var id = $(this).attr('id');
    $.ajax("/site/set-read?id=" + id);
});

// portrait位置更改
// 如果屏幕尺寸小于768，将其置于.navbar .navbar-header顶部
// 如果屏幕尺寸大于768，将其置于#navigation .nav尾部
$(document).ready(changePortrait);
$(window).resize(changePortrait);

function changePortrait() {
    // 清楚原有
    $('[id=portrait]').parent(':not(#portrait-template)').find('[id=portrait]').remove();
    var $portrait = $($('#portrait-template').html()).popover({
        placement: "bottom",
        html: true,
        content: $('#portrait-items').html(),
        template: '<div class="popover" role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    });
    if (window.screen.width > 768) {
        $('#navigation .nav').append($portrait);
    } else {
        $('.navbar .navbar-header').prepend($portrait);
    }
}

$('#navigation').on('show.bs.collapse', function () {
    $('.navbar.navbar-transparent').css('background-color', 'rgb(8, 0, 88)');
}).on('hidden.bs.collapse', function () {
    setTimeout(function () {
        $('.navbar.navbar-transparent').css('background-color', 'transparent');
    }, 0);
});

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
$(document).ready(function () {

    if (window.location.pathname.indexOf('/fund/') !== -1 && window.screen.width <= 1024) {
        $(".sidebar-left").removeClass('hidden-xs').css({ "width": "100%" });
        $(".sidebar").css({ "width": "100%", "position": "relative", "top": "", "bottom": "", "margin-top": '10px' });
        $('.sidebar-left').css('height', $('.sidebar').innerHeight() + 20);
        console.log("remove");
    } else {
        if ($('.sidebar-right').innerHeight() > $('.sidebar').innerHeight() + 120) {
            $('.sidebar-left').css('height', $('.sidebar-right').innerHeight());
        } else {
            $('.sidebar-left').css('height', $('.sidebar').innerHeight() + 120);
        }
    }
    $(window).scroll(function () {
        var topp = $(document).scrollTop();
        var left = topp + $('.sidebar').innerHeight() + 100;
        var right = $('.sidebar-right').offset().top + $('.sidebar-right').innerHeight();
        //console.log($('.sidebar').innerHeight(),left,right)
        if ($(".sidebar") && topp > 250) {
            if (left <= right) {
                $(".sidebar").css({ "position": "fixed", "top": "0px", "bottom": "" });
            } else {
                $(".sidebar").css({ "position": "relative", "top": $('.sidebar-right').innerHeight() - $('.sidebar').innerHeight() - 110 + "px", "bottom": "" });
            }
        }
        if ($(".sidebar") && topp <= 250) {
            $(".sidebar").css({ "position": "relative", "top": "", "bottom": "" });
        }

        if (window.location.pathname.indexOf('/fund/') !== -1 && window.screen.width <= 1024) {
            $(".sidebar-left").removeClass('hidden-xs').css({ "width": "100%" });
            $(".sidebar").css({ "width": "100%", "position": "relative", "top": "", "bottom": "", "margin-top": '10px' });
        }
    });
});