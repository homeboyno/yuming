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


/**------------------------------------------
 *  兼容性
 ------------------------------------------*/
$('[modernizr-svg="' + (!Modernizr.svg).toString() + '"]').hide();
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
