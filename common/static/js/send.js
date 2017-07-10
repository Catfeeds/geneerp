$(function () {
    //发送验证码全局变量
    var curCount = 0;//当前剩余秒数
    var counts = 60; //间隔函数，1秒执行
    var InterValObj; //timer变量，控制时间
    var mobileReg = /^1[34578]{1}[0-9]{9}$/;//手机正则
    var emailReg = /^[a-zA-Z0-9._%+-]+@(?!.*\.\..*)[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;//邮箱正则
    var letterNumberReg = /^[0-9a-zA-Z]+$/;//只能填写数字与英文字母
    //timer处理函数
    function setSmsTime(btn) {
        if (curCount === 0) {
            window.clearInterval(InterValObj);//停止计时器
            btn.prop('disabled', false);
            btn.text('获取短信验证码');
        } else {
            curCount--;
            btn.text('重新获取 ' + curCount + ' s');
        }
    }
    function setEmailTime(btn) {
        if (curCount === 0) {
            window.clearInterval(InterValObj);//停止计时器
            btn.prop('disabled', false);
            btn.text('获取邮箱验证码');
        } else {
            curCount--;
            btn.text('重新获取 ' + curCount + ' s');
        }
    }
    //失败后点击验证码
    function captchaClick(formName) {
        var captchaImageName = formName + ' .captcha-image';
        var captchaName = 'input[name="' + formName + '[captcha]"]';
        if ($(captchaImageName).size() > 0) {
            $(captchaName).val('');
            $(captchaName).focus();
            $(captchaImageName).click();
        }
    }

    $('#sms-code-btn').click(function () {
        var btnThis = $(this);
        var formName = $(this).attr('data-form');
        if ($('#mobile').length > 0) {
            var mobileName = '#mobile';
        } else {
            var mobileName = 'input[name="' + formName + '[mobile]"]';
        }
        var captchaName = 'input[name="' + formName + '[captcha]"]';
        var mobile = $(mobileName).val();
        var captcha = $(captchaName).val();

        if (mobile === '') {
            $(mobileName).focus();
            showDialog('手机号不能为空');
            return false;
        }
        if (captcha === '') {
            $(captchaName).focus();
            showDialog('验证码不能为空');
            return false;
        }
        if (!mobileReg.test(mobile)) {
            $(mobileName).focus();
            showDialog('手机号格式错误');
            return false;
        }
        if (captcha.length !== 4 || !letterNumberReg.test(captcha)) {
            $(captchaName).focus();
            showDialog('验证码格式错误');
            return false;
        }
        btnThis.prop('disabled', true);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: btnThis.attr('data-url'),
            data: getCsrf() + '&mobile=' + mobile + '&captcha=' + captcha + '&type=' + btnThis.attr('data-type'),
            success: function (data) {
                if (data.status === 1) {
                    //开始计时
                    curCount = counts;
                    InterValObj = window.setInterval(function () {
                        setSmsTime(btnThis);
                    }, 1000);
                } else {
                    captchaClick(formName);
                    btnThis.prop('disabled', false);
                    showDialog(data.msg);
                }
            },
            error: function () {
                captchaClick(formName);
                btnThis.prop('disabled', false);
                showDialog('系统错误，请重试');
            }
        });
        return false;
    });

    $('#email-code-btn').click(function () {
        var btnThis = $(this);
        var formName = $(this).attr('data-form');
        if ($('#email').length > 0) {
            var emailName = '#email';
        } else {
            var emailName = 'input[name="' + formName + '[email]"]';
        }
        var captchaName = 'input[name="' + formName + '[captcha]"]';
        var email = $(emailName).val();
        var captcha = $(captchaName).val();

        if (email === '') {
            $(emailName).focus();
            showDialog('邮箱不能为空');
            return false;
        }
        if (captcha === '') {
            $(captchaName).focus();
            showDialog('验证码不能为空');
            return false;
        }
        if (!emailReg.test(email)) {
            $(emailName).focus();
            showDialog('邮箱格式错误');
            return false;
        }
        if (captcha.length !== 4 || !letterNumberReg.test(captcha)) {
            $(captchaName).focus();
            showDialog('验证码格式错误');
            return false;
        }
        btnThis.prop('disabled', true);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: btnThis.attr('data-url'),
            data: getCsrf() + '&email=' + email + '&captcha=' + captcha + '&type=' + btnThis.attr('data-type'),
            success: function (data) {
                if (data.status === 1) {
                    //开始计时
                    curCount = counts;
                    InterValObj = window.setInterval(function () {
                        setEmailTime(btnThis);
                    }, 1000);
                } else {
                    captchaClick(formName);
                    btnThis.prop('disabled', false);
                    showDialog(data.msg);
                }
            },
            error: function () {
                captchaClick(formName);
                btnThis.prop('disabled', false);
                showDialog('系统错误，请重试');
            }
        });
        return false;
    });
});