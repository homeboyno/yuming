/*! =========================================================
 *
 * Material Dashboard - V1.1.0
 *
 * =========================================================
 *
 * Copyright 2016 Creative Tim (http://www.creative-tim.com/product/material-dashboard)
 *
 *
 *                       _oo0oo_
 *                      o8888888o
 *                      88" . "88
 *                      (| -_- |)
 *                      0\  =  /0
 *                    ___/`---'\___
 *                  .' \|     |// '.
 *                 / \|||  :  |||// \
 *                / _||||| -:- |||||- \
 *               |   | \\  -  /// |   |
 *               | \_|  ''\---/''  |_/ |
 *               \  .-\__  '-'  ___/-. /
 *             ___'. .'  /--.--\  `. .'___
 *          ."" '<  `.___\_<|>_/___.' >' "".
 *         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *         \  \ `_.   \_ __\ /__ _/   .-` /  /
 *     =====`-.____`.___ \_____/___.-`___.-'=====
 *                       `=---='
 *
 *     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *               Buddha Bless:  "No Bugs"
 *
 * ========================================================= */

// Material Dashboard Wizard Functions
(function(){
	isWindows = navigator.platform.indexOf('Win') > -1 ? true : false;

	if (isWindows && !$('body').hasClass('sidebar-mini')){
	   // if we are on windows OS we activate the perfectScrollbar function
	   $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

	   $('html').addClass('perfect-scrollbar-on');
   } else {
	   $('html').addClass('perfect-scrollbar-off');
   }
})();


var searchVisible = 0;
var transparent = true;

var transparentDemo = true;
var fixedTop = false;

var mobile_menu_visible = 0,
	mobile_menu_initialized = false,
	toggle_initialized = false,
	bootstrap_nav_initialized = false;

var seq = 0,
	delays = 80,
	durations = 500;
var seq2 = 0,
	delays2 = 80,
	durations2 = 500;


$(document).ready(function() {

	$sidebar = $('.sidebar');

	$.material.ripples('.dashboard-list .item, .sidebar .nav li a')

	$.material.init();

	md.initSidebarsCheck();

	window_width = $(window).width();

	// check if there is an image set for the sidebar's background
	md.checkSidebarImage();

	md.initMinimizeSidebar();

	//  Activate the tooltips
	$('[rel="tooltip"]').tooltip();


	$('.form-control').on("focus", function() {
		$(this).parent('.input-group').addClass("input-group-focus");
	}).on("blur", function() {
		$(this).parent(".input-group").removeClass("input-group-focus");
	});

});

// activate collapse right menu when the windows is resized
$(window).resize(function() {
	md.initSidebarsCheck();

	// reset the seq for charts drawing animations
	seq = seq2 = 0;

});

md = {
	misc: {
		navbar_menu_visible: 0,
		active_collapse: true,
		disabled_collapse_init: 0,
	},

	checkSidebarImage: function() {
		$sidebar = $('.sidebar');
		image_src = $sidebar.data('image');

		if (image_src !== undefined) {
			sidebar_container = '<div class="sidebar-background" style="background-image: url(' + image_src + ') "/>'
			$sidebar.append(sidebar_container);
		}
	},

	initSidebarsCheck: function() {
		if ($(window).width() <= 991) {
			if ($sidebar.length != 0) {
				md.initRightMenu();
			} else {
				md.initBootstrapNavbarMenu();
			}
		}
	},

	checkScrollForTransparentNavbar: debounce(function() {
		if ($(document).scrollTop() > 260) {
			if (transparent) {
				transparent = false;
				$('.navbar-color-on-scroll').removeClass('navbar-transparent');
			}
		} else {
			if (!transparent) {
				transparent = true;
				$('.navbar-color-on-scroll').addClass('navbar-transparent');
			}
		}
	}, 17),


	initRightMenu: debounce(function() {
		$sidebar_wrapper = $('.sidebar-wrapper');

		if (!mobile_menu_initialized) {
			$navbar = $('nav').find('.navbar-collapse').first().clone(true);

			nav_content = '';
			mobile_menu_content = '';

			$navbar.children('ul').each(function() {

				content_buff = $(this).html();
				nav_content = nav_content + content_buff;
			});

			nav_content = '<ul class="nav nav-mobile-menu">' + nav_content + '</ul>';

			$navbar_form = $('nav').find('.navbar-form').clone(true);

			$sidebar_nav = $sidebar_wrapper.find(' > .nav');

			// insert the navbar form before the sidebar list
			$nav_content = $(nav_content);
			$nav_content.insertBefore($sidebar_nav);
			$navbar_form.insertBefore($nav_content);

			$(".sidebar-wrapper .dropdown .dropdown-menu > li > a").click(function(event) {
				event.stopPropagation();

			});

			mobile_menu_initialized = true;
		} else {
			if ($(window).width() > 991) {
				// reset all the additions that we made for the sidebar wrapper only if the screen is bigger than 991px
				$sidebar_wrapper.find('.navbar-form').remove();
				$sidebar_wrapper.find('.nav-mobile-menu').remove();

				mobile_menu_initialized = false;
			}
		}

		if (!toggle_initialized) {
			$toggle = $('.navbar-toggle');

			$toggle.click(function() {

				if (mobile_menu_visible == 1) {
					$('html').removeClass('nav-open');

					$('.close-layer').remove();
					setTimeout(function() {
						$toggle.removeClass('toggled');
					}, 400);

					mobile_menu_visible = 0;
				} else {
					setTimeout(function() {
						$toggle.addClass('toggled');
					}, 430);


					main_panel_height = $('.main-panel')[0].scrollHeight;
					$layer = $('<div class="close-layer"></div>');
					$layer.css('height', main_panel_height + 'px');
					$layer.appendTo(".main-panel");

					setTimeout(function() {
						$layer.addClass('visible');
					}, 100);

					$layer.click(function() {
						$('html').removeClass('nav-open');
						mobile_menu_visible = 0;

						$layer.removeClass('visible');

						setTimeout(function() {
							$layer.remove();
							$toggle.removeClass('toggled');

						}, 400);
					});

					$('html').addClass('nav-open');
					mobile_menu_visible = 1;

				}
			});

			toggle_initialized = true;
		}
	}, 500),


	initBootstrapNavbarMenu: debounce(function() {

		if (!bootstrap_nav_initialized) {
			$navbar = $('nav').find('.navbar-collapse').first().clone(true);

			nav_content = '';
			mobile_menu_content = '';

			//add the content from the regular header to the mobile menu
			$navbar.children('ul').each(function() {
				content_buff = $(this).html();
				nav_content = nav_content + content_buff;
			});

			nav_content = '<ul class="nav nav-mobile-menu">' + nav_content + '</ul>';

			$navbar.html(nav_content);
			$navbar.addClass('off-canvas-sidebar');

			// append it to the body, so it will come from the right side of the screen
			$('body').append($navbar);

			$toggle = $('.navbar-toggle');

			$navbar.find('a').removeClass('btn btn-round btn-default');
			$navbar.find('button').removeClass('btn-round btn-fill btn-info btn-primary btn-success btn-danger btn-warning btn-neutral');
			$navbar.find('button').addClass('btn-simple btn-block');

			$toggle.click(function() {
				if (mobile_menu_visible == 1) {
					$('html').removeClass('nav-open');

					$('.close-layer').remove();
					setTimeout(function() {
						$toggle.removeClass('toggled');
					}, 400);

					mobile_menu_visible = 0;
				} else {
					setTimeout(function() {
						$toggle.addClass('toggled');
					}, 430);

					$layer = $('<div class="close-layer"></div>');
					$layer.appendTo(".wrapper-full-page");

					setTimeout(function() {
						$layer.addClass('visible');
					}, 100);


					$layer.click(function() {
						$('html').removeClass('nav-open');
						mobile_menu_visible = 0;

						$layer.removeClass('visible');

						setTimeout(function() {
							$layer.remove();
							$toggle.removeClass('toggled');

						}, 400);
					});

					$('html').addClass('nav-open');
					mobile_menu_visible = 1;

				}

			});
			bootstrap_nav_initialized = true;
		}
	}, 500),

	startAnimationForLineChart: function(chart) {

		chart.on('draw', function(data) {
			if (data.type === 'line' || data.type === 'area') {
				data.element.animate({
					d: {
						begin: 600,
						dur: 700,
						from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
						to: data.path.clone().stringify(),
						easing: Chartist.Svg.Easing.easeOutQuint
					}
				});
			} else if (data.type === 'point') {
				seq++;
				data.element.animate({
					opacity: {
						begin: seq * delays,
						dur: durations,
						from: 0,
						to: 1,
						easing: 'ease'
					}
				});
			}
		});

		seq = 0;
	},
	startAnimationForBarChart: function(chart) {

		chart.on('draw', function(data) {
			if (data.type === 'bar') {
				seq2++;
				data.element.animate({
					opacity: {
						begin: seq2 * delays2,
						dur: durations2,
						from: 0,
						to: 1,
						easing: 'ease'
					}
				});
			}
		});

		seq2 = 0;
	},
	initMinimizeSidebar: function() {
		// when we are on a Desktop Screen and the collapse is triggered we check if the sidebar mini is active or not.
		// If it is active then we don't let the collapse to show the elements because the elements from the collapse are showing on the hover state over the icons in sidebar mini, not on the click.
		$('.sidebar .collapse').on('show.bs.collapse', function() {
			if ($(window).width() > 991 && md.misc.sidebar_mini_active == true) {
				return false;
			} else {
				return true;
			}
		});

		$('#minimizeSidebar').click(function() {
			var $btn = $(this);

			if (md.misc.sidebar_mini_active == true) {
				$('body').removeClass('sidebar-mini');
				$('.sidebar .logo img').attr('src', $('.sidebar .logo img').attr('src').replace('Logo', 'Name'))
				md.misc.sidebar_mini_active = false;
			} else {
				$('.sidebar .collapse').collapse('hide').on('hidden.bs.collapse', function() {
					$(this).css('height', 'auto');
				});

				setTimeout(function() {
					$('body').addClass('sidebar-mini');
					$('.sidebar .logo img').attr('src', $('.sidebar .logo img').attr('src').replace('Name', 'Logo'))
					$('.sidebar .collapse').css('height', 'auto');
					md.misc.sidebar_mini_active = true;
				}, 300);
			}

			// we simulate the window Resize so the charts will get updated in realtime.
			var simulateWindowResize = setInterval(function() {
				window.dispatchEvent(new Event('resize'));
			}, 180);

			// we stop the simulation of Window Resize after the animations are completed
			setTimeout(function() {
				clearInterval(simulateWindowResize);
			}, 1000);
		});
	},
	initDashboardPageCharts: function(){
		eightHourVisitChart = {
			labels: eightHourVisitLabel,
			series: [eightHourVisitCount]
		};
		optionsEightHourVisitChart = {
			lineSmooth: Chartist.Interpolation.cardinal({
				tension: 0
			}),
			low: 0,
			high: eightHourVisitUpLimit, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
			chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
		}
		var eightHourVisitChart = new Chartist.Line('#eightHourVisit', eightHourVisitChart, optionsEightHourVisitChart);
		md.startAnimationForLineChart(eightHourVisitChart);



		eightHourUserChart = {
			labels: eightHourUserLabel,
			series: [eightHourUserCount]
		};
		optionsEightHourUserChart = {
			lineSmooth: Chartist.Interpolation.cardinal({
				tension: 0
			}),
			low: 0,
			high: eightHourUserUpLimit, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
			chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
		}
		var eightHourUserChart = new Chartist.Line('#eightHourUser', eightHourUserChart, optionsEightHourUserChart);
		md.startAnimationForLineChart(eightHourUserChart);


		weeklyVisitChart = {
			labels: weeklyVisitLabel,
			series: [weeklyVisitCount]
		};
		optionsWeeklyVisitChart = {
			lineSmooth: Chartist.Interpolation.cardinal({
				tension: 0
			}),
			low: 0,
			high: weeklyVisitUpLimit, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
			chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
		}
		var weeklyVisitChart = new Chartist.Line('#weeklyVisitChart', weeklyVisitChart, optionsWeeklyVisitChart);
		md.startAnimationForLineChart(weeklyVisitChart);
	}
}


// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this,
			args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};

/**------------------------------------------
 *       Config
  ------------------------------------------*/
var NotifyDefaultOptions = {
	icon: "notifications",
	type: "info",
	from: "top",
	align: "right",
	timer: 2000
}

var DeleteConfirmSwal = {
  title: "你要确定删除吗？",
  text: "记录一旦删除将不可恢复，请确认！",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "确认删除",
  cancelButtonText: "取消",
  closeOnConfirm: false,
  closeOnCancel: true,
  showLoaderOnConfirm: true
}

var DeleteErrorSwal = {
  title: "删除失败！",
  text: "您没有选择需要删除的项目",
  type: "warning",
  confirmButtonText: "确认",
}

var DeleteSuccessSwal = {
  title: "已删除!",
  text: "记录已被移除",
  type: "success",
  confirmButtonText: "确认",
}

var DeleteFailSwal = {
	title: "删除失败！",
    text: "部分项目无法删除",
    type: "warning",
    confirmButtonText: "确认",
}

if ($.pjax) {
	$.pjax.defaults.timeout = 10000;
	$.pjax.defaults.enablePushState = false;
	$.pjax.defaults.enableReplaceState = false;
}

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
		data["eventName"] = eventName
		var event = new CustomEvent('ZEvent', {detail: data})
		window.parent.document.dispatchEvent(event)
	}
	this.transmit = function(target, eventName, data) {
		data["transmitEventName"] = eventName
		data["transmitTarget"] = target
		this.emit('transmit', data)
	}
}

var zEvent = new ZEvent();
window.document.addEventListener('ZEvent', function(event) {
	var eventName = event.detail.eventName;
	zEvent.trigger(eventName, event)
}, false)

// only top frame listen this event
zEvent.on('transmit', function(data) {
	var target = data["transmitTarget"];
	delete data["transmitTarget"];
	data.eventName = data.transmitEventName;
	delete data["transmitEventName"];
	var event = new CustomEvent('ZEvent', {detail: data});
	$(target).contents()[0].dispatchEvent(event)
})

zEvent.on('load', function(data) {
	if (data.target == "#dashboard-modal") {
		$(data.target).parents(".modal-dialog").attr("class", "modal-dialog")
		if (data.modal_size) {
			$(data.target).parents(".modal-dialog").addClass(data.modal_size)
		}
		$(data.target).parents(".modal").modal("show").end().one('load', function() {
			// 令iframe高度等于文档高度，重置body为auto的原因是因为height原为100vh
			var documentHeight = $('#dashboard-modal').contents().find('html').height('auto').end().height();
			$('#dashboard-modal').height(documentHeight)
		})
	}
	if (data.expanded) {
		$('.main-panel').addClass('expanded')
	} else if (!data.expaned && $('.main-panel').addClass('expanded')) {
		$('.main-panel').removeClass('expanded')
	}
	if (data.model_size) {
		$("#dashboard-modal").parents(".modal-dialog").src("class", "modal-dialog").addClass(data.model_size)
	}
	$(data.target).attr('src', data.url);
})

$('#dashboard-modal').parents('.modal').on('hidden.bs.modal', function() {
	$('#dashboard-modal').attr('src', '');
	$('#dashboard-modal').removeAttr('style');
})

zEvent.on('refresh', function(data) {
	if ($(data.target).length != 0) {
		$(data.target)[0].src = $(data.target)[0].src;
	}
})

zEvent.on('confirm-delete', function(data) {
	// data.swal.bind(window)()
	function confirmCallback(isConfirm) {
		if (isConfirm) {
			var requestList = [],
				CSRFtoken = $('meta[name=csrf-token]').attr('content');
			for (var i = 0; i < data.deleteList.length; i++) {
				requestList.push($.ajax({ type: 'POST', url: data.deleteList[i], headers: { 'X-CSRF-Token': CSRFtoken } }));
			}

			function callback() {
				// location.reload();
				data.callback.bind(window)()
				swal(DeleteSuccessSwal);
			}
			$.when.apply(null, requestList).then(function() {
				if(data.successCallback) data.successCallback.bind(window)()
				swal(DeleteSuccessSwal);
			}, function() {
				if(data.failCallback) data.failCallback.bind(window)()
				swal(DeleteFailSwal);
			})
		}
	}

	if (data.deleteList.length != 0) { // 未选择
		swal(DeleteConfirmSwal, confirmCallback)
	} else {
		swal(DeleteErrorSwal)
	}
})

zEvent.on('notify', function(data) {
	data = $.extend(NotifyDefaultOptions, data);
	$.notify({
		icon: data.icon,
		message: data.message
	}, {
		type: data.type,
		timer: data.timer,
		placement: {
			from: data.from,
			align: data.align
		}
	})
})

zEvent.on('pjax-reload', function(data) {
	// pjaxContainer, reloadUrl
	$.pjax.reload(data.pjaxContainer, {url: data.reloadUrl, push: false, replace: false})
})

zEvent.on('modal-close', function(data) {
	$("#dashboard-modal").parents(".modal").modal("hide");
})

zEvent.on('upload', function(data) {
	$("body").data("aurora.upload", null)
	$("body").upload(data).upload('show')
})

$(document).ready(function() {
	/**------------------------------------------
	 *       Mini Sidebar Menu Controller
	 ------------------------------------------*/
	var miniSidebarList = [];
	$(".sidebar .sidebar-wrapper > ul > li").each(function() {
		var $ul = $(this).find(".collapse ul"),
			ulHTML = $ul.parent().clone()
					.children().removeClass("nav").addClass("sidebar-popover-nav").end().html();
		if ($ul.length != 0) {
			miniSidebarList.push($(this));
			$(this).popover({
				placement: 'right',
				content: ulHTML,
				html: true,
				trigger: 'manual',
				container: 'body',
				template: '<div class="popover" role="tooltip"><div class="arrow" style="margin-top: 0"></div><h3 class="popover-title"></h3><div class="popover-content" style="padding: 5px"></div></div>'
			}).on('show.bs.popover', function(e) {
				if (!$('body').hasClass('sidebar-mini')) e.preventDefault()
				else {
					$(this).data('popoverShown', true)
					if ($('#popover-backdrop').length == 0) {
						var backdrop = $('<div id="popover-backdrop" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 100"></div>');
						$('body').append(backdrop)
					}
				}
			}).on('shown.bs.popover', function(e) {
				var $this = $(this),
					$popover = $this.data('bs.popover').$tip,
					rect = [
						[$this.offset().left, $this.offset().top], // 左 左上
						[$this.offset().left, $this.offset().top + $this.height()], // 左 左下
						[$popover.offset().left, $popover.offset().top], // 右 左上
						[$popover.offset().left, $popover.offset().top + $popover.height()], // 右 左下
					];

				$popover.find("li").on("click.popover", function() { $this.siblings().removeClass("active").end().addClass("active") })
				function upper_limit(x) {
					// y1 = y2/x2*x1
					var y2 = rect[0][1] - rect[2][1],
						x2 = rect[2][0] - rect[0][0],
						y = y2 / x2 * (x - rect[0][0]);

					return rect[0][1] - y;
				}

				function lower_limit(x) {
					// y1 = y2/x2*x1
					var y2 = rect[3][1] - rect[1][1],
						x2 = rect[3][0] - rect[1][0],
						y = y2 / x2 * (x - rect[1][0]);

					return rect[1][1] + y;
				}

				function inMovingArea(x, y) {
					if (x >= rect[0][0] && x <= rect[2][0]) {
						if (y >= upper_limit(x) && y <= lower_limit(x)) {
							return true;
						}
					}
					return false;
				}

				function inPopoverArea(x, y) {
					var p1 = [$popover.offset().left, $popover.offset().top],
						p2 = [$popover.offset().left + $popover.width(), $popover.offset().top + $popover.height()];

					if (x >= p1[0] && x <= p2[0]) {
						if (y >= p1[1] && y <= p2[1]) return true;
					}

					return false;
				}

				$('body').on('mousemove' + '.' + $(this).attr('id'), function(event) {
					var x = event.pageX, y = event.pageY;
					if (!inMovingArea(x, y) && !inPopoverArea(x, y)) {
						$this.popover('hide')
						$popover.find("li").off("click.popover")
					}
				})
			}).on('hidden.bs.popover', function(e) {
				$(this).data('popoverShown', false);
				$('body').off('mousemove' + '.' + $(this).attr('id'));
				var keepDropback = false;
				for(var i = 0; i < miniSidebarList.length; i++) {
					keepDropback = miniSidebarList[i].data('popoverShown') || keepDropback;
				}
				if(!keepDropback) $('#popover-backdrop').remove();
			}).mouseenter(function() {
				if(!$(this).data('popoverShown')) $(this).popover('show')
			})
		} else {
			$(this).popover({
				placement: 'right',
				content: $(this).find("p").text(),
				trigger: 'hover',
				container: 'body',
				template: '<div class="popover" role="tooltip"><div class="arrow" style="margin-top: 0;"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
			}).on('show.bs.popover', function(e) {
				if (!$('body').hasClass('sidebar-mini')) e.preventDefault()
			})
		}
	})
	/**------------------------------------------
	 *       Top Menu Controller
	 ------------------------------------------*/
	$(document).on('click', ".sidebar-wrapper ul > li", function(e) {
		if ($(this).find('[data-toggle="collapse"]').length == 0) {
			$(".sidebar-wrapper ul > li.active").removeClass("active");
			$(this).addClass("active");
			$(".navbar-brand").text($(this).find("p").text())
		}
		if ($(this).parents(".collapse").length == 1) {
			e.stopPropagation()
			$(this).addClass("active")
			$(".navbar-brand").text($(this).text())
		}
	})
	// list-menu popover setting
	$('#list-menu-toggle, #list-menu > button, #multiple-menu > button').popover({placement: 'left', trigger: 'hover'})
	$('#list-menu-toggle').mouseenter(function() {
		$(this).next().find('.arrow').css('top', '75%');
	})
	$('#list-menu > button, #multiple-menu > button').mouseenter(function() {
		var $popover = $(this).next('.popover')
		$popover.css('top', parseInt($popover.css('top')) + 10 + 'px')
		$popover.css('left', parseInt($popover.css('left')) - 3 + 'px')
	})
	// initial backdrop
	var $contentWrapper = $(".before-load-backdrop").next();
	if ($(".before-load-backdrop").length == 1) {
		$contentWrapper.hide();
	}
	// 删除.before-load-backdrop
	$('.before-load-backdrop').remove()
	$contentWrapper.show()
	// 开启日期选择
	$('.datepicker').datepicker({
		weekStart: 1,
		format: 'yyyy-mm-dd'
	});


	/**------------------------------------------
	 *       Dashboard List Controller
	 ------------------------------------------*/
	$(document).on('click', '.dashboard-list .item[data-load]', function() {
		var that = this;
		setTimeout(function() {
			$('.dashboard-list .item[data-load]').removeClass('selected')
			$(that).addClass('selected')
		}, 500);
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

	$(".sidebar-wrapper ul > li.active a").each(function() {
		zEvent.emit('load', {
			url: $(this).data('url') || $(this).attr('href'),
			target: $(this).data('load'),
			expanded: !!$(this).attr('expanded')
		})
	})

	/**------------------------------------------
	 *       Dashboard List Menu
	 ------------------------------------------*/
	$("#list-menu-toggle").data("status", "closed").data("multiple-status", "closed")
	$("#list-menu").hide()
	var $controlButton = $("#list-menu-toggle"),
      ListMenuDuration = 300;

	function openListMenu() {
		if ($controlButton.data('status') == "closed") {
			$("#list-menu").show()
			$controlButton.find(".menu").hide().end().find(".close").show()
			$("#list-menu > button").each(function(index, element) {
				$(element).animate({
					top: (index + 1) * -60
				}, ListMenuDuration)
			})
			setTimeout(function() {
				$controlButton.data('status', "opened")
			}, ListMenuDuration)
		}
	}

	function closeListMenu() {
		if ($controlButton.data('status') == "opened") {
			$controlButton.find(".menu").show().end().find(".close").hide()
			$("#list-menu > button").each(function(index, element) {
				$(element).animate({
					top: 0
				}, ListMenuDuration)
			})
			setTimeout(function() {
				$("#list-menu").hide()
				$controlButton.data('status', "closed")
			}, ListMenuDuration)
		}
	}

	function closeMultipleMenu() {
		if ($controlButton.data('multiple-status') == "opened") {
			$('.dashboard-list .multiple-choose').remove()
			$controlButton.find(".menu").show().end().find(".close").hide()
			$("#multiple-menu > button").each(function(index, element) {
				$(element).animate({
					top: 0
				}, ListMenuDuration)
			})
			setTimeout(function() {
				$("#multiple-menu").hide()
				$controlButton.data('multiple-status', "closed")
			}, ListMenuDuration)
		}
	}

	function openMultipleMenu() {
		if ($controlButton.data('multiple-status') == "closed") {
			$("#multiple-menu").show()
			$controlButton.find(".menu").hide().end().find(".close").show()
			$("#multiple-menu > button").each(function(index, element) {
				$(element).animate({
					top: (index + 1) * -60
				}, ListMenuDuration)
			})
			setTimeout(function() {
				$controlButton.data('multiple-status', "opened")
			}, ListMenuDuration)
		}
	}

	$controlButton.on('click', function() {
		if ($controlButton.data('status') == "closed") {
      		closeMultipleMenu();
			openListMenu();
		} else {
			closeListMenu();
		}
	})

	/**------------------------------------------
	 *  Dashboard Delete handler
	 ------------------------------------------*/
	$(document).on('click.dashboard', '[multiple-choose-mode]', function(e) {
    closeListMenu();
    openMultipleMenu();
		// 为dashboard-list .item 添加多选按钮
		$(".dashboard-list .item").each(function() {
      $(this).prepend('<div class="checkbox multiple-choose"><label><input type="checkbox"><span class="checkbox-material"><span class="check"></span></label></div> ')
		})
	})

	// 阻止多选时产生跳转
	$(document).on('click.dashboard', '.multiple-choose', function(e) {
		e.stopPropagation();
	})

	// 全选
	$(document).on("click.dashboard", "[choose-all]", function(e) {
		var status = !$(this).data("checked");
		if (status) {
			$(this).find(".choose").show().end().find(".unchoose").hide();
		} else {
			$(this).find(".choose").hide().end().find(".unchoose").show();
		}
		$(".checkbox.multiple-choose input").each(function() {
			if ($(this).is(":checked") !== status) $(this).click()
		})
		$(this).data("checked", status)
	})

	// 删除
	$(document).on('click.dashboard', '[confirm-delete]', function(e) {
		var deleteList = [];
		$(".multiple-choose").each(function() {
			if ($(this).find('input').is(':checked')) {
				var deleteUrl = $(this).parent().data('delete-url')
				deleteList.push(deleteUrl)
			}
		})

		zEvent.emit('confirm-delete', {
			deleteList: deleteList,
			successCallback: function() { location.reload(); }
		})
	})

	$(document).on('click.dashboard', '[pjax-delete]', function(e) {
		var deleteList = [];
		deleteList.push($(this).data("url"))
		var $pjaxContainer = $(this).parents('[data-pjax-container]'),
			reloadUrl = $pjaxContainer.data('reload-url');
		zEvent.emit('confirm-delete', {
			deleteList: deleteList,
			successCallback: function() {
				$.pjax.reload($pjaxContainer, {url: reloadUrl, push: false, replace: false})
			}
		})
	})

	$(document).on('click.dashboard', '[pjax-multiple-delete]', function(e) {
		var target = $(this).attr('pjax-multiple-delete'),
			$grid = $(target),
			data = $grid.yiiGridView('data'),
			deleteList = [];

		if (data.selectionColumn) {
			$grid.find("input[name='" + data.selectionColumn + "']:checked").each(function () {
				deleteList.push($(this).parents('tr').find('[pjax-delete]').data('url'));
			});
		}

		var $pjaxContainer = $grid.parents('[data-pjax-container]'),
			reloadUrl = $pjaxContainer.data('reload-url');

		zEvent.emit('confirm-delete', {
			deleteList: deleteList,
			successCallback: function() {
				$.pjax.reload($pjaxContainer, {url: reloadUrl, push: false, replace: false})
			}
		})
	})

	$(document).on('pjax:success', function(event) {
		$.material.ripples();
		$.material.input();
		$.material.checkbox();
		$.material.radio();
		$.material.togglebutton();
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
})
