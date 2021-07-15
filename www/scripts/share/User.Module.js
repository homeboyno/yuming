/**------------------------------------------
 *       Event Handler
  ------------------------------------------*/
function ZEvent() {
	this.eventStack = {};
	this.on = function(eventName, callback) {
		this.eventStack[eventName] = callback;
	}
	this.trigger = function(eventName, event) {
		if (typeof this.eventStack[eventName] == "function") {
			this.eventStack[eventName](event.detail);
		}
	}
	this.emit = function(eventName, data) {
		if (!data) data = {};
		data["source"] = window.frameElement ? "#" + window.frameElement.id : null;
		data["eventName"] = eventName;
		var event = new CustomEvent('ZEvent', {detail: data});
		window.parent.document.dispatchEvent(event)
	}
	this.transmit = function(target, eventName, data) {
		data["transmitEventName"] = eventName;
		data["transmitTarget"] = target;
		this.emit('transmit', data);
	}
}

var zEvent = new ZEvent();
window.document.addEventListener('ZEvent', function(event) {
	var eventName = event.detail.eventName;
	zEvent.trigger(eventName, event)
}, false);

// only top frame listen this event
zEvent.on('transmit', function(data) {
	var target = data["transmitTarget"];
	delete data["transmitTarget"];
	data.eventName = data.transmitEventName;
	delete data["transmitEventName"];
	var event = new CustomEvent('ZEvent', {detail: data});
	$(target).contents()[0].dispatchEvent(event)
});

zEvent.on('load', function(data) {
	if (data.target == "#modal") {
		$(data.target).parents(".modal-dialog").attr("class", "modal-dialog")
		if (data.modal_size) {
			$(data.target).parents(".modal-dialog").addClass(data.modal_size)
		}
		$(data.target).parents(".modal").modal("show").end().one('load', function() {
			zEvent.emit('resize-modal')
		})
	}
	if (data.expanded == "maintain") {
	} else if (data.expanded) {
		$('.main-panel').addClass('expanded')
	} else if (!data.expaned && $('.main-panel').addClass('expanded')) {
		$('.main-panel').removeClass('expanded')
	}
	if (data.model_size) {
		$("#modal").parents(".modal-dialog").src("class", "modal-dialog").addClass(data.model_size)
	}
	$(data.target).attr('src', data.url);
});

zEvent.on('resize-modal', function(data) {
	var target = data.target ? data.target : data.source;
	// 令iframe高度等于文档高度，重置body为auto的原因是因为height原为100vh
	var documentHeight = $(target).contents().find('html').height('auto').height();
	$(target).height(documentHeight)
	if (data && data.modal_size)
		$(target).parents(".modal-dialog").addClass(data.modal_size)
});

zEvent.on('refresh', function(data) {
	if ($(data.target).length != 0) {
		$(data.target)[0].src = $(data.target)[0].src;
	} else {
		window.location.reload();
	}
});

zEvent.on('modal-close', function(data) {
	var target = data.target ? data.target : "#dashboard-modal";
	if (data.target) {
		$(data.target).parents(".modal").modal("hide");
	} else {
		$(data.source).parents(".modal").modal("hide");
	}
})

/**------------------------------------------
 *  Dashboard Instruction handler
 ------------------------------------------*/
$("[notify]").each(function() {
	zEvent.emit("notify", {
		message: $(this).attr('message'),
		type: $(this).attr('type'),
		icon: $(this).attr('icon'),
		timer: $(this).attr('timer'),
		align: $(this).attr('align'),
		from: $(this).attr('from'),
	})
})

$("[refresh]").each(function() {
	zEvent.emit("refresh", {target: $(this).data('target')})
})

$("[pjax-reload]").each(function() {
	zEvent.transmit($(this).attr('target'), "pjax-reload", {
	  pjaxContainer: $(this).attr('pjaxContainer'),
	  reloadUrl: $(this).attr('reloadUrl')
	})
})

$("[modal-close]").each(function() {
	zEvent.emit("modal-close", {})
})

$(document).on('click', '[data-load]', function(e) {
	if ($(this).is('a')) e.preventDefault() // prevent redirect
	zEvent.emit('load', {
		url: $(this).data('url') || $(this).attr('href'),
		target: $(this).data('load'),
		expanded: !!$(this).attr('expanded'),
		modal_size: $(this).attr('modal-size')
	})
})

$('[modernizr-svg="' + (!Modernizr.svg).toString() + '"]').hide();

$('#LoginModal input[ng-model="password"]').keydown(function(e) {
    if (e.keyCode == 13) {
        Login()
    }
})

var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE");

if (msie > 0 && msie <= 8) {
    $('.container:not(footer .container) > .col-md-2 > .sidebar').parent().css({"margin-left":"5%", "width": "11.67%", "float": "left"})
    $('.container:not(footer .container) > .col-md-10').css({"width": "83.33%", "float": "left"})
    $('.container:not(footer .container) > .col-md-9').css({"width": "75%", "float": "left"})
    $('footer, footer > .container, footer > .col-md-12').css({"width": "100%"})
    $('footer .container > .col-md-6').css({"width": "50%", "float": "left"})
    if(window.location.pathname == "/company/index") {
        $(".party-photo.col-sm-6").css({"width": "50%", "float": "left"})
    }
    if(window.location.pathname == "/news/index") {
        $(".news-list").css({"width": "100%", "float": "left"})
        $(".news-list .col-sm-4").css({"width": "33.33%", "float": "left"})
    }
}

if (!Modernizr.input.placeholder) {
    $('.input-group label').show();
}

$('.navbar-nav span').bind('click', function(e) {
    $(this).siblings('a').click();
});

$(document).ready(function() {
    if ($(window).width() < 950) {
        $('button.ubtn[data-target="#LoginModal"]').removeClass('ubtn-sm').addClass('ubtn-lg');
    }
});

$('[action="back-to-top"]').click(function() {
    $body = window.opera ? "CSS1Compat" == document.compatMode ? $("html") : $("body") : $("html,body"),
        $body.animate({
            scrollTop: 0
        }, 800);
});
/***************** Smooth Scrolling ******************/
$('a[href*=#]:not([href=#])').click(function(e) {
    if ($(this).parents('.nav-tabs').length == 1) {
        return;
    }
    if ($(this).attr("href") === "#banner") {
        return;
    }
    if ($(this).attr("href") === "#departments") {
        return;
    }
    if ($(this).attr("href") === "#about-depart") {
        return;
    }
    if ($(this).attr("href") === "#workstyle-carousel") {
        return;
    }
    if (window.location.pathname == "/product/index") {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top
            }, 500);
            return false;
        }
        return;
    }
    if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top - 70
            }, 500);
            return false;
        }
    }
});

$('footer [data-target]').click(function() {
    $('#Navbar span[data-target="' + $(this).data('target') + '"]').click();
})

function Ajax(para_url, para_json) {
    var result;
    $.ajax({
        type: "POST",
        data: para_json,
        url: para_url,
        dataType: "json",
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}

function wberrorWarning(message) {
    var target = $('.alert-danger');
    target.text(message);
    target.show("normal");
    setTimeout('$(".alert-danger").hide("fast")', 5000);
}

$(".captcha").click(function() {
	var that = this;
    $.get('/site/captcha?refresh=1')
        .success(function() {
            $(that).attr('src', '/site/captcha?' + Math.random())
					.parent().find(".help-block").text();
        })
})

function Logout() {
    var result = Ajax('/site/logout');
    if (result.success) {
        User.login = false;
        $('.navbar-right li[data-target="#LoginModal"]').show('fast');
        $('#portrait').hide('fast');
        $('.Navbar [data-target="#LoginModal"]').show();
        $('.left-menu-overlay').click();
    } else {
        errorWarning("网络不稳定");
    }
}

function AppendRiskTest() {
    $('#RegisterModal input[ng-model="agreecontract"]').val('true');
    if (!$('#RiskControlModal .modal-body').data('loaded')) {
        $.ajax({
            type: "GET",
            url: '/site/risk-test',
            async: false,
            success: function(data) {
                $('#RiskControlModal .modal-body').append(data)
                $('#RiskControlModal .modal-body').data('loaded', true)
                var $container = $('#RiskControlModal')
                initRiskTest($container)
            }
        });
    }
}

function initRiskTest($container) {
    $container.find('input[type="radio"]').hide();
    $container.find('input[type="radio"]').each(function() {
        $this = $(this);
        var value = $this.val();
        var name = $this.attr('name');
        $this.parent().prepend('<i class="fa fa-circle-o" value="' + value + '" name="' + name + '"></i><i class="fa fa-check-circle" value="' + value + '" name="' + name + '"></i>');
    });
    $('.fa-check-circle').hide();

    function setRadio(name, value) {
        $container.find('input[type="radio"][name="' + name + '"]').each(function() {
            $(this).removeAttr("checked");
            $(this).siblings('.fa-check-circle').hide();
            $(this).siblings('.fa-circle-o').show();
        });
        var des = $container.find('input[type="radio"][name="' + name + '"][value="' + value + '"]');
        des.attr("checked", true);
        des.siblings('.fa-circle-o').hide();
        des.siblings('.fa-check-circle').show();
    }

    $('.fa').click(function() {
        var value = $(this).attr("value");
        setRadio($(this).attr('name'), value);
    });
}

function getVal($container, name) {
    return $container.find('input[type="radio"][name="' + name + '"][checked]').val();
}

function RiskTestSubmit(target) {
    var $container = $(target).parents("[data-name='riskTestContainer']"),
        number = parseInt($("#risk-test-number").data("number"))

    var score = 0;
    for (i = 1; i <= number; i++) {
        if (getVal($container, i) == undefined) {
            $('.alert-danger').show('fast');
            return false;
        }
        score += parseInt(getVal($container, i));
    }
    $('#RiskControlModal .alert-danger').hide('fast');
    var message = null;
    if (score <= 20) {
        message = "您属于低风险投资者 。适合的产品保障本金，且预期收益受风险因素影响很小；或产品不保障本金但本金和预期收益受风险因素影响很小，且具有较高流动性。";
    } else if (score >= 21 && score <= 40) {
        message = "您属于较低风险投资者 。适合的产品不保障本金但本金和预期收益受风险因素影响较小；或承诺本金保障但产品收益具有较大不确定性的结构性存款理财产品。";
    } else if (score >= 41 && score <= 60) {
        message = "您属于中风险投资者 。适合的产品不保障本金，风险因素可能对本金和预期收益产生一定影响。";
    } else if (score >= 61 && score <= 80) {
        message = "您属于较高风险投资者 。适合的产品不保障本金，风险因素可能对本金产生较大影响，产品结构存在一定复杂性。";
    } else {
        message = "您属于高风险投资者。适合的产品不保障本金，风险因素可能对本金造成重大损失，产品结构较为复杂，可使用杠杆运作。";
    }
    $container.find('.alert-success').text(message).show('fast');
    $(target).hide('fast');
    $container.find('[data-target="#RegisterModal"]').removeAttr('disabled');
    $container.find('.alert-warning').show('fast');
    var params = new Object();
    params.riskscore = score;
    var result = Ajax('/site/risk-test', params);
    if (result.success && window.location.pathname != "/site/site-risk-test") {
        setTimeout(function() {
            window.location.pathname = '/site/index';
        }, 10000)
    }
}

var Charts = Array();
// **************** Chart *****************
function getChartData(value) {
    var labels = Array(),
        data = Array(),
        type = Array(),
        datasets = Array();
    for (var i = value.length - 1; i >= 0; i--) {
        var index = $.inArray(value[i]["type"], type),
            time = value[i]["time"].replace(" 00:00:00", "");
        if (index >= 0) {
            if ($.inArray(time, labels) === -1) {
                labels.push(time);
            }
            data[index].push(value[i]["fvalue"]);
        } else {
            var index = data.push(Array());
            type.push(value[i]["type"]);
            if ($.inArray(time, labels) === -1) {
                labels.push(time);
            }
            data[index - 1].push(value[i]["fvalue"]);
        }
    };
    if (type.length == 1) {
        datasets.push({
            label: "基金净值",
            fillColor: "rgba(135,197,193, 0.8)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: data[0]
        });
    } else {
        for (var i = type.length - 1; i >= 0; i--) {
            if (type[i] == "1") {
                datasets.push({
                    label: "A类净值",
                    fillColor: "rgba(32,178,170, 0.6)",
                    strokeColor: "rgba(255,255,255,1)",
                    pointColor: "rgba(175,238,238,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: data[i]
                });
            } else {
                datasets.push({
                    label: "B类净值",
                    fillColor: "rgba(135,197,193, 0.8)",
                    strokeColor: "rgba(255,255,255,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    data: data[i],
                });
            }
        };
    }
    return {
        labels: labels,
        datasets: datasets
    };
}
var ChartOptions = {
    responsive: true,
    showScale: false,
    pointDot: false,
    bezierCurveTension: 0.25,
    pointDotRadius: 0,
    pointDotStrokeWidth: 0,
    datasetStrokeWidth: 4,
    tooltipYOffset: -10,
    animation: Modernizr.canvas,
    multiTooltipTemplate: "<%= datasetLabel %>: <%= value %>",
};

if (!Modernizr.canvas) {
    window.onload = function() {
        $('#Funds [data-chart]').each(function() {
            var chart = $(this);
            chart.css('display', 'block');
            chart.parents('.content').css('display', 'block');
            chart.parents('.content').children().css('display', 'block');

            chart.width(280);
            chart.height(280 / 5);
            ctx = chart[0].getContext("2d"),
                LineDataSet = getChartData(JSON.parse(chart.attr('data-chart')));
            Charts.push(new Chart(ctx).Line(LineDataSet, ChartOptions));
            // fund value
            var new_fund_value = LineDataSet.datasets[0].data[LineDataSet.datasets[0].data.length - 1];
            chart.siblings(".info").children(".number").text(new_fund_value);
        })
    }
}

$(document).ready(function() {

    $('.left-logo-overlay').bind('click', function() {
        setTimeout(function() {
            window.location.pathname = "/";
        }, 500)
    });
    // .Navbar 初始化
    var navbar_blue_list = [];
    var isNavbarBlue = typeof(defaultNavbarBlue) != 'undefined' ? defaultNavbarBlue : function() {
        for (var i = navbar_blue_list.length - 1; i >= 0; i--) {
            if (navbar_blue_list[i].test(window.location.pathname))
                return true;
        };
        return false;
    }();

    function blueNavbar() {
        $('.Navbar .u-navbar-nav span').addClass('blue');
        $('.Navbar .u-navbar-nav button').removeClass('btn-white').addClass('btn-blue');
        $('[data-target="#Menu"]').addClass('blue');
    }

    function whiteNavbar() {
        $('.Navbar .u-navbar-nav span').removeClass('blue');
        $('.Navbar .u-navbar-nav button').removeClass('btn-blue').addClass('btn-white');
        $('[data-target="#Menu"]').removeClass('blue');
    }

    if (isNavbarBlue) blueNavbar(); // 默认白色
    // 鼠标移入大屏幕Navbar按钮渐入动效
    $('.content').on('transitionend', function(e) {
        e.stopPropagation();
    })

    $('.left-menu-overlay').click(function() {
        if (!Modernizr.csstransitions) { // add animation for IE8
            $('.menu-overlay').animate({
                width: '0'
            }, "normal", "linear");
        } else {
            $('.menu-overlay').removeClass('active').removeClass('menu');
        }
        $('.left-menu-overlay').removeClass('active');
        $('.u-navbar-nav span').removeClass('active');
        $('.menu-overlay').children('.content').css('display', 'none').children().css('display', 'none');
        var delay = 0;
        // 大屏幕收缩后菜单栏动效
        $('.Navbar > .u-navbar-nav > span, .Navbar > .u-navbar-nav > button').removeClass('animated fadeInDown').each(function() {
            var target = $(this);
            setTimeout(function() {
                target.addClass('animated fadeInDown');
            }, delay);
            delay = delay + 50;
        });
        // 调整菜单栏颜色
        if (isNavbarBlue) blueNavbar();
        // 是否是手机Menu菜单开闭
        if ($('[data-target="#Menu"]').hasClass('active')) {
            $('[data-target="#Menu"]').removeClass('active');
            $('.Navbar > .u-navbar-nav').css('display', 'none');
        }
    });

    // 只在小屏幕才出现的菜单栏
    $('[data-target="#Menu"]').click(function() {
        // 调整菜单栏颜色
        if (isNavbarBlue) whiteNavbar();
        $('menu-overlay .content').css('display', 'none');
        if ($(this).hasClass('active')) { //如果菜单栏已经打开
            $('.left-menu-overlay').click();
        } else {
            $(this).addClass('active');
            if (!Modernizr.csstransitions) { // add animation for IE8
                $('.menu-overlay').animate({
                    width: '280px'
                }, "normal", "linear");
            } else {
                $('.menu-overlay').addClass('menu');
            }
            $('.left-menu-overlay').addClass('active');
            $('.Navbar > .u-navbar-nav').css({
                'display': 'block',
            });
        }
    });

    $('.Navbar > .u-navbar-nav > span[data-target], #portrait').click(function() {
        var transition = $.support.transition

        if ($(this).attr('data-toggle') == "modal") {
            return;
        }
        var target = $(this).attr('data-target');
        // 调整菜单栏颜色
        if (isNavbarBlue) whiteNavbar();
        // 隐藏所有的.content及子元素
        $('.menu-overlay > .content').each(function() {
            $(this).css('display', 'none').children().css('display', 'none');
        })
        if (target == "#LoginModal") {
            return;
        }
        $('.amap-pancontrol, .amap-locate, .amap-zoomcontrol').css('display', 'none');
        $(this).siblings().removeClass('active');
        // 唤出menu-overlay层及关闭层动效
        if (!Modernizr.cssanimations) { // add animation for IE8
            $('.menu-overlay').animate({
                width: '50%'
            }, "normal", "linear", function() {
                $(this).trigger('showtarget', [target]);
            });
            // 修正菜单栏已展开时不激发 transitionend 事件的问题
            if ($('.menu-overlay').width() == parseInt($('body').width() / 2)) {
                $('.menu-overlay').trigger('showtarget', [target]);
            }
        } else {
            if ($('.menu-overlay').hasClass('active')) {
                $('.menu-overlay').trigger('showtarget', [target]);
            }
            $('.menu-overlay').addClass('active').emulateTransitionEnd(300)
        }

        $(this).addClass('active');
        $('.left-menu-overlay').addClass('active');
        // 如果是在小屏幕操作，则应该隐藏一级菜单
        if ($('[data-target="#Menu"]').hasClass('active')) {
            $('.Navbar > .u-navbar-nav').css('display', 'none');
        }
        $('.menu-overlay').on('bsTransitionEnd', function(e) {
            if ($('.menu-overlay').hasClass('active') || $('.menu-overlay').width() > 20) {
                $('.menu-overlay').trigger('showtarget', [target]);
            }
        });
    });

    $('.menu-overlay').on('showtarget', function(e, target) {
        // 删除对事件的监听，防止重复触发 .content 的显示
        $('.menu-overlay').off('transitionend');
        $('.menu-overlay').off('bsTransitionEnd');
        $(target).css('display', 'block');
        var delay = 0;
        $(target).children().each(function() {
            var child = $(this);
            // 控制Navbar .content的子元素逐个渐入的动效
            setTimeout(function() {
                if (!Modernizr.csstransitions) { // add animation for IE8
                    child.css({
                        'display': 'block',
                        'opacity': 0,
                        'padding-left': child.width()
                    }).animate({
                        opacity: 1,
                        'padding-left': 0
                    }, "normal", "linear");
                } else {
                    child.css('display', 'block').addClass('animated fadeInRight');
                }

                if (target == '#News' && !Modernizr.backgroundsize) {
                    $('#News .news-img').removeClass('news-img');
                    setTimeout(function() {
                        $('#News > div > div > div:not(.news-title)').addClass('news-img');
                    }, 1000);
                }
            }, delay);
            setTimeout(function() {
                child.removeClass('animated fadeInRight');
            }, 1100 + delay);
            delay = delay + 100;
        });
    });

    /* ==========================================================================
    Navbar
    ========================================================================== */
})

$('.contact-close').on('click', function() {
    $('#contact-modal').modal('hide')
})

$('#contact-modal .fa.fa-phone, #contact-modal img').on('mouseenter', function() {
    var top = $(this).parent().height() / 2 + $(this).height() / 2 + 20;
    var left, $target = $(this).siblings('.contact-tooltip');
    if (navigator.appVersion.indexOf("MSIE") != -1) {
        left = ($target.parent().width() - $target.innerWidth()) / 2;
    } else {
        left = -($target.innerWidth() + $(this).innerWidth()) / 2;
    }
    $target.css({
        'margin-left': left,
        top: top
    }).addClass('animated fadeInDown').css('visibility', 'visible');
});

$(document).on('show.bs.modal', '#register-server-contact', function() {
    $.get('/site/register-contract')
        .success(function(response) {
            $('#register-server-contact .modal-body').html(response)
        })
})

$('.sidebar.multiple ul.open').slideToggle();
$('.sidebar.multiple p').click(function() {
    var that = $(this).next('ul')[0];
    $(this).parents('.sidebar').find("ul").each(function() {
        if ($(this).hasClass('open') && that != this) $(this).removeClass("open").slideToggle();
    })
    $(this).next('ul').slideToggle().addClass("open");
})
