if (window.location.pathname.indexOf('/news/index')) {
    $(document).ready(function() {
        var parent_width = $('.news-container').width();

        $('.news-container img').css({
            'max-width': parent_width + 'px'
        });

    });
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


if (window.location.pathname == '/site/site-risk-test') {
    $(document).ready(function() {
        $('#RiskTestModal input[type="radio"]').hide();
        $('#RiskTestModal input[type="radio"]').each(function() {
            $this = $(this);
            var value = $this.val();
            var name = $this.attr('name');
            $this.parent().prepend('<i class="fa fa-circle-o" value="' + value + '" name="' + name + '"></i><i class="fa fa-check-circle" value="' + value + '" name="' + name + '"></i>');
        });
        $('.fa-check-circle').hide();

        function setRadio(name, value) {
            $('#RiskTestModal input[type="radio"][name="' + name + '"]').each(function() {
                $(this).removeAttr("checked");
                $(this).siblings('.fa-check-circle').hide();
                $(this).siblings('.fa-circle-o').show();
            });
            var des = $('#RiskTestModal input[type="radio"][name="' + name + '"][value="' + value + '"]');
            des.attr("checked", true);
            des.siblings('.fa-circle-o').hide();
            des.siblings('.fa-check-circle').show();
        }

        function getVal(name) {
            return $('#RiskTestModal input[type="radio"][name="' + name + '"][checked]').val();
        }

        $('.fa').click(function() {
            var value = $(this).attr("value");
            setRadio($(this).attr('name'), value);
        });

        $('#RiskTestSubmit_1').click(function() {
            var score = 0;
            for (i = 1; i <= 8; i++) {
                if (getVal(i) == undefined) {
                    $('.alert-danger').show('fast');
                    return false;
                }
                score += parseInt(getVal(i));
            }
            $('#RiskTestModal .alert-danger').hide('fast');
            var message = null;
            if (score <= 14) {
                message = "您属于保守型投资者 。在风险和收益的天平之间，您态度鲜明的维护“低风险”乃是投资第一要义。您反对进取型投资者关于投资的那种态度，因为您是一位保守型投资者。 ";
            } else if (score >= 15 && score <= 19) {
                message = "您属于稳健型投资者 。您对投资的风险和回报都有深刻的了解，您更愿意用最小的风险来获得确定的收益。您是一个比较平稳的投资者。风险偏好偏低，稳健是您一贯的风格。";
            } else if (score > 20 && score <= 26) {
                message = "您属于平衡型投资者 。您的风险偏好偏高，但是还没有达到热爱风险的地步，您对投资的期望是用适度的风险换取合理的回报。如果您能坚持自己的判断并进行合理的规划，您会取得良好的投资回报。";
            } else {
                message = "您属于进取型投资者。您明白高风险高回报、低风险低回报的投资定律。您可能还年轻，对未来的收入充分乐观。在对待风险的问题上，您属于风险偏好型。";
            }
            $('#RiskTestModal .alert-success').text(message).show('fast');
            $('#PreRiskMessage').text(message);
            $('#RiskTestSubmit_1').hide('fast');
            $('#RiskTestModal [data-target="#RegisterModal"]').removeAttr('disabled');
            $('#RiskTestModal .alert-warning').show('fast');
            var params = new Object();
            params.riskscore = score;
            var result = Ajax('/site/risk-test', params);
        });
    });
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
if (window.location.pathname.indexOf('/site/about-ushinef') !== -1) {
    function redirect() {
        $('.u-navbar-nav span:eq(2)').click();
    }

    $(document).ready(function() {
        $(".wp1").waypoint(function() {
            $(".wp1").addClass("animated fadeInDown");
        }, {
            offset: "75%"
        });
        $(".wp2").waypoint(function() {
            $(".wp2").addClass("animated fadeInLeft");
        }, {
            offset: "75%"
        });
        $(".wp3").waypoint(function() {
            $(".wp3").addClass("animated fadeInRight");
        }, {
            offset: "75%"
        });
        $(".wp4").waypoint(function() {
            $(".wp4").addClass("animated fadeInDown");
        }, {
            offset: "75%"
        });
        $(".wp5").waypoint(function() {
            $(".wp5").addClass("animated fadeInUp");
        }, {
            offset: "75%"
        });
        $(".nav-wrap").waypoint(function() {
            ShowStructure();
        }, {
            offset: "75%"
        });
    });
}

if (window.location.pathname.indexOf('/company/detail') !== -1) {
    $(document).ready(function() {
        $(".wp1").waypoint(function() {
            $(".wp1").addClass('animated fadeInRight');
        }, {
            offset: "75%"
        });
        $(".wp2").waypoint(function() {
            $(".wp2").addClass('animated fadeInRight');
        }, {
            offset: "75%"
        });
        $(".wp3").waypoint(function() {
            $(".wp3").addClass('animated fadeInRight');
        }, {
            offset: "75%"
        });
    });
}