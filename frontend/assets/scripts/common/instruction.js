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
