const LoginAlert = [{
    title: "访问受限",
    text: "你没有权限查看该文件，请注册或登录！",
    type: "warning",
    className: "btn",
    confirmButtonClass: "btn-primary",
    cancelButtonText: "取消",
    showCancelButton: true,
    closeOnCancel: true,
    confirmButtonText: "登录",
    closeOnConfirm: true,
}, function() { // 确认回调
    window.location = "/user/login";
}]

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
        if (_Chart) _Chart.destroy()
        _Chart = new Chart(ctx).Line(LineDataSet, ChartOptions);
        // document.getElementById('js-legend').innerHTML = _Chart.generateLegend();
    }
}

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
        fillColor: "rgba(8, 0, 88, 0.8)",
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

            if (_Chart) _Chart.destroy()
            _Chart = new Chart(ctx).Line(LineDataSet, ChartOptions);
            // document.getElementById('js-legend').innerHTML = _Chart.generateLegend();
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

function showNotify(url) {
    $.get(url).then(function(response) {
        $('#notify').find('.modal-content').html(response).end().modal()
    })
}

$(this).data('expand', false)
$("#expand").click(function() {
    if ($(this).data('expand')) {
        $(this).data('expand', false)
        $(this).text('展开')
        $(this).siblings('p').css("overflow", "hidden").css("max-height", "12.3em")
    } else {
        $(this).data('expand', true)
        $(this).text('收起')
        $(this).siblings('p').css("overflow", "auto").css("max-height", "initial")
    }
})

$('#buy').click(function() {
    swal({
        title: "申购申请",
        text: "填写您的申购金额",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "确认",
        cancelButtonText: "取消",
        inputPlaceholder: "申购金额",
    }, function (value) {
        if (value === false) return false;
        if (value === "") {
            swal.showInputError("金额不能为空");
            return false
        }
        if (!/^\d+$/.test(value)) {
            swal.showInputError("您需要输入一个数字");
            return false
        }
        if (value < 1000000) {
            swal.showInputError("根据证监局规定，私募产品申购金额不得低于壹佰万圆");
            return false
        }
        $.ajax({
            url: '/user/reservation', 
            method: 'POST',
            data: {
                fund_id: window.location.search.match(/id=(\d+)/)[1],
                money: value
            }
        }).then(function(response) {
            swal({
                title: "已发起申购",
                text: "您的申购金额是" + digitUppercase(value) + "，我们将尽快与您联系！", 
                confirmButtonText: "确认",
                type: "success"
            })
        })
    });
})