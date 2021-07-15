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
