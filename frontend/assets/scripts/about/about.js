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

function AppointConfirm() {
    var params = new Object();
    params["fund_id"] = $('#appoint_fund').val();

    if ($('#type').val() != '1' && $('#type').val() != '2') {
        AppointError('请选择申购／赎回');
        return;
    }
    params["type"] = $('#type').val();

    var money = parseInt($('input[name="money"]').val().replace(/,/g, ''));
    if (money < 100000) {
        AppointError('申购或赎回的金额需大于拾万元');
        return;
    }
    params["money"] = money;

    var result = Ajax('/appointment/addtional', params);
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


if (window.location.pathname.indexOf('company/detail') !== -1) {
    var map = new AMap.Map("container", {
        resizeEnable: true
    });
    AMap.service(["AMap.PlaceSearch"], function() {
        var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
            pageSize: 1,
            pageIndex: 1,
            city: "010", //城市
            map: map,
            panel: "panel"
        });
        //关键字查询
        var address,
            company = window.location.pathname.match(/\/company\/detail\/(\d+)/)[1];
        switch (company) {
            case "7":
                address = '成都市高新区交子大道';
                break;
            default:
                address = $('#container').data('address');
                break;
        }
        placeSearch.search(address);
    });
}

function ErrorTip(message) {
    $('.alert-danger').text(message).show();
    setTimeout(function() {
        $('.alert-danger').hide();
    }, 2000);
}

function SuccessTip(message) {
    $('.alert-success').text(message).show();
    setTimeout(function() {
        $('.alert-success').hide();
    }, 2000);
}