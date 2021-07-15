// sidebar init
$(document).ready(function() {
    var pathname = window.location.pathname;
    $('a[href="' + pathname + '"]').parent().addClass('active');
});


var digitUppercase = function(n) {
    var fraction = ['角', '分'];
    var digit = [
        '零', '壹', '贰', '叁', '肆',
        '伍', '陆', '柒', '捌', '玖'
    ];
    var unit = [
        ['元', '万', '亿'],
        ['', '拾', '佰', '仟']
    ];
    var head = n < 0 ? '欠' : '';
    n = Math.abs(n);
    var s = '';
    for (var i = 0; i < fraction.length; i++) {
        s += (digit[Math.floor(n * 10 * Math.pow(10, i)) % 10] + fraction[i]).replace(/零./, '');
    }
    s = s || '整';
    n = Math.floor(n);
    for (var i = 0; i < unit[0].length && n > 0; i++) {
        var p = '';
        for (var j = 0; j < unit[1].length && n > 0; j++) {
            p = digit[n % 10] + unit[1][j] + p;
            n = Math.floor(n / 10);
        }
        s = p.replace(/(零.)*零$/, '').replace(/^$/, '零') + unit[0][i] + s;
    }
    return head + s.replace(/(零.)*零元/, '元')
        .replace(/(零.)+/g, '零')
        .replace(/^整$/, '零元整');
};

var _Chart;

var ChartOptions = {
    responsive: true,
    showScale: true,
    pointDot: true,
    bezierCurveTension: 0.25,
    tooltipYOffset: -10,
    animation: Modernizr.canvas,
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
    tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
    multiTooltipTemplate: "<%= datasetLabel %>: <%= value %>",
};

window.onload = function() {
    var $target = $('[data-chart]');
    if ($target.length != 0) {
        var ctx = $target[0].getContext("2d"),
            LineDataSet = getChartData(JSON.parse($target.attr('data-chart')));
        _Chart = new Chart(ctx).Line(LineDataSet, ChartOptions);
        document.getElementById('js-legend').innerHTML = _Chart.generateLegend();
    }
       
}

/***************** Appointment ******************/
$('#AppointModal input').bind('focus', function() {
    if ($(this).parents('.form-group').hasClass('has-error')) {
        $(this).parents('.form-group').removeClass('has-error');
    }
})

function Appoint() {
    if (User.login) {
        $('#AppointModal').modal('show');
    } else {
        $('#LoginModal').modal('show');
    }
}

function commafy(num) {
    num = num === NaN ? 0 : num;
    num = num + "";
    var re = /(-?\d+)(\d{3})/;
    while (re.test(num)) {
        num = num.replace(re, "$1,$2");
    }
    return num;
}

function AppointError(message) {
    $('#AppointModal .alert-danger').text(message).show('fast');
    setTimeout(function() {
        $('#AppointModal .alert-danger').hide('fast');
    }, 3000);
}

$('input[name="money"]').keyup(function() {
    var moneytext = $(this).val().replace(/\D|^0/g, ''),
        moneyint = moneytext == '' ? 0 : parseInt(moneytext);
    $(this).val(commafy(moneyint));
    $('#chinamoney').text(digitUppercase(moneytext));
}).bind("paste", function() {
    var moneytext = $(this).val().replace(/\D|^0/g, ''),
        moneyint = moneytext == '' ? 0 : parseInt(moneytext);
    $(this).val(commafy(moneyint));
    $('#chinamoney').text(digitUppercase(moneytext));
}).css("ime-mode", "disabled");

function AppointConfirm() {
    var params = new Object();
    // params["fund_id"] = window.location.pathname.split('/')[3];
    params["fund_id"] = $('#AppointModal').find('input[name="fund_id"]').val()

    var money = parseInt($('input[name="money"]').val().replace(/,/g, ''));
    if (money < 1000000) {
        AppointError('投资金额需大于壹佰万元');
        return;
    }
    params["money"] = money;

    var result = Ajax('/site/reservation', params);
    if (result.success) {
        $('#AppointModal .alert-danger').hide('fast');
        $('#AppointModal .alert-success').text('已经成功预约！我们会尽快与您联系').show('fast');
        setTimeout(function() {
            $('#AppointModal .alert-success').hide('fast');
            $('#AppointModal').modal('hide');
        }, 2000);
    } else {
        AppointError('由于网络原因预约失败，请稍后重试');
    }
}

$(document).ready(function() {
    $('[data-toggle="counterup"]').counterUp({
        delay: 10,
        time: 300
    });
});


// var Charts = Array();
// /***************** Chart ******************/
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
    return {
        labels: labels,
        datasets: datasets
    };
}

function updatePageInfo() {
    var currentPage = parseInt($('[data-chart]').data('page')),
        pageCount = parseInt($('[data-chart]').attr('data-page-count'))

    $('#canvas-pager .next').removeClass('disabled')
    $('#canvas-pager .prev').removeClass('disabled')

    if (currentPage == 1) {
        $('#canvas-pager .next').addClass('disabled')
    }
    if (currentPage == pageCount) {
        $('#canvas-pager .prev').addClass('disabled')
    }
}

function updateCanvas(id, page) {
    $.get('/fund/more-fund-value', { id: id, page: page })
        .success(function(response) {
            $('[data-chart]').data('page', page)
            updatePageInfo()
            var $target = $('[data-chart]'),
                ctx = $target[0].getContext("2d"),
                LineDataSet = getChartData(response)

            _Chart = new Chart(ctx).Line(LineDataSet, ChartOptions);
            document.getElementById('js-legend').innerHTML = _Chart.generateLegend();
        })
}

// init canvas pager
updatePageInfo()

$('[data-action="chart-prev"]').click(function() {
    var currentPage = parseInt($('[data-chart]').data('page')),
        pageCount = parseInt($('[data-chart]').attr('data-page-count'))

    if (currentPage == pageCount) return
    updateCanvas($('[data-chart]').data('fid'), currentPage + 1)
})

$('[data-action="chart-next"]').click(function() {
    var currentPage = parseInt($('[data-chart]').data('page')),
        pageCount = parseInt($('[data-chart]').attr('data-page-count'))

    if (currentPage == 1) return
    updateCanvas($('[data-chart]').data('fid'), currentPage - 1)
})
