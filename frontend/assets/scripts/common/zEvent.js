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

/**
 * Listen event of swal
 * You can call this function like
 * zEvent.emit('swal', [{title: '...', text: '...', type: 'warning', confirmButtonText: 'Confirm'}])
 */
zEvent.on('swal', function(data) {
	delete data["eventName"];
	delete data["source"];

	var arguList = $.map(data, function(value, index) {
	   return [value];
	});
	swal.apply(null, arguList)
})