var zEvent = new ZEvent();
window.document.addEventListener("ZEvent", function(event) {
    var eventName = event.detail.eventName;
    zEvent.trigger(eventName, event)
}, false);

zEvent.emit("resize-modal");

// 默认将背景设为透明，且禁止滚动
$("body").css("background", "transparent").css("overflow", "hidden");
$(".form-control").on("blur", function() {
    zEvent.emit("resize-modal");
})

function showError(message) {
    var $target = $(".summary").text(message).show("fast");
    zEvent.emit("resize-modal");
    setTimeout(function() {
        $target.hide();
        zEvent.emit("resize-modal");
    }, 5000);
}

$(".help-block").each(function() {
    if ($(this).text().length != 0) {
        showError($(this).text())
    }
})

$("#update-pwd-form")
    .on("afterValidate", function() {
        var display = false;
        $(".help-block").each(function() {
            if ($(this).text().length != 0 && !display) {
                showError($(this).text())
                display = true;
            }
        })
    })
    .on("beforeSubmit", function(e) {
        password = $(this).find("[type=password]").val()
        $(this).find("[type=password]").val(hex_md5(password))
    });

var CountDown = null,
    time = 60;

$("#send-verify").click(function (e) {
    e.preventDefault();
    if ($("input[name='UpdatePwdForm[verify]']").val().length == 0) {
        showError("验证码不能为空");
        return;
    }
    if (CountDown !== null) {
        showError("已经在一分钟内发送过短信，请等待");
        return;
    }

    var params = {
        "SMSForm[token]": $("input[name='UpdatePwdForm[token]']").val(),
        "SMSForm[captcha]": $("input[name='UpdatePwdForm[verify]']").val()
    };

    $.ajax({
        type: "POST",
        data: params,
        url: "/site/sms",
    }).success(function(response) {
        $(".captcha").click();
        if (response.success) {
            CountDown = setInterval(function() {
                time--;
                if (time == 0) {
                    clearInterval(CountDown);
                    CountDown = null;
                    $("#send-verify").text("发送验证码");
                    time = 60;
                } else {
                    var message = "已发送(" + time + ")";
                    $("#send-verify").text(message);
                }
            }, 1000);
        } else {
            showError(response.message);
        }
    })
});
