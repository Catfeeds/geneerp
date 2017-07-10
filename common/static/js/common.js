
/* global layer */
//JS随机数
function S4() {
    return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
}
function getGuid() {
    return (S4() + S4() + '-' + S4() + '-' + S4() + '-' + S4() + '-' + S4() + S4() + S4());
}
//获取TOKEN
function getCsrf() {
    var param = $('meta[name=csrf-param]');
    var token = $('meta[name=csrf-token]');//需要encodeURI
    if (param.length > 0 && token.length > 0) {
        var str = param.attr('content') + '=' + encodeURI(token.attr('content')) + "&_time=" + Math.random();
        console.log(str);
        return str;
    }
    return false;
}
//ajax返回成功操作
function ajaxSuccess(btn) {
    return function (data, statusText) {
        if (statusText === 'success') {
            if (data.status === 0) {
                btn.prop('disabled', false);
            }
            showDialog(data.msg, data.type, data.url, data.status);
        } else {
            btn.prop('disabled', false);
            showDialog('Server error');
        }
    };
}
//ajax返回错误操作
function ajaxError(btn) {
    return function (request, exception) {
        btn.prop('disabled', false);
        var msg = '';
        if (request.status === 0) {
            msg = 'Not connect.';
        } else if (request.status === 404) {
            msg = 'Requested page not found [404].';
        } else if (request.status === 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.' + request.responseText;
        }
        showDialog(msg);
    };
}
//ajax操作消息对话框
function showDialog(msg, type, url, status) {
    var icon = 0;//对话框图标
    if (arguments.length === 4) {
        if (status === 1) {//成功
            icon = 6;
        } else if (status === 0) {//失败
            icon = 5;
        }
    } else if (arguments.length === 1) {//如果只有一个参数则type=1
        type = 1;
    }

    if (type === 1) {//弹出信息，3秒后自动消失
        layer.msg(msg, {time: 3000, icon: icon, btnAlign: 'c'});
    } else if (type === 2) {//弹出信息，2秒后自动重定向，URL参数必填
        layer.msg(msg, {time: 2000, icon: icon, btnAlign: 'c'}, function () {
            window.top.location.href = url;
        });
    } else if (type === 3) {//弹出信息，2秒后自动重载当前页
        layer.msg(msg, {time: 2000, icon: icon, btnAlign: 'c'}, function () {
            window.top.location.reload();
        });
    } else if (type === 4) {//弹出信息，2秒后自动返回上一页
        layer.msg(msg, {time: 2000, icon: icon, btnAlign: 'c'}, function () {
            window.history.go(-1);
        });
    } else if (type === 5) { //自动重定向
        window.top.location.href = url;
    } else if (type === 6) {//自动重载当前页
        window.top.location.reload();
    } else if (type === 7) {//自动返回上一页
        window.history.go(-1);
    }
}
function _ajax(btn, params) {
    layer.msg('加载中...', {icon: 16, shade: 0.01, time: 0});
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: btn.attr('data-url'),
        data: getCsrf() + '&' + btn.attr('data-params') + '&' + params,
        success: ajaxSuccess(btn),
        error: ajaxError(btn)
    });
}
//打开自定义HTML内容
function openSelectDialog(btn) {
    var message = '确认 ' + btn.text() + ' 操作吗？';
    if (typeof (btn.attr('data-message')) !== 'undefined') {
        message = btn.attr('data-message');
    }
    layer.open({
        type: 1,
        title: message,
        content: $('#' + btn.attr('data-model')),
        btn: ['确定', '关闭'],
        btnAlign: 'c',
        yes: function (index) {
            var value = $('#' + btn.attr('data-id')).val();
            if (value === '') {
                layer.msg('请选择');
                return false;
            }
            layer.close(index);
            _ajax(btn, 'value=' + value);
            return false;
        },
        cancel: function () { //右上角关闭回调
            btn.prop('disabled', false);
        },
        btn2: function (index, layero) {
            btn.prop('disabled', false);
            layer.close(index);
        }
    });
}
//prompt层
function promptDialog(btn) {
    var type = 0;//0文本框 1密码文本框 2多行文本框
    var max = 500;//最多输入文字数量
    var title = '请输入内容';//提示标题
    var value = '';//默认内容
    var confirm = '';//是否需要确认一次
    var message = '';//第二次提示信息
    if (typeof (btn.attr('data-type')) !== 'undefined') {
        type = btn.attr('data-type');
    }
    if (typeof (btn.attr('data-max')) !== 'undefined') {
        max = btn.attr('data-max');
    }
    if (typeof (btn.attr('data-title')) !== 'undefined') {
        title = btn.attr('data-title');
    }
    if (typeof (btn.attr('data-message')) !== 'undefined') {
        message = btn.attr('data-message');
    }
    if (typeof (btn.attr('data-value')) !== 'undefined') {
        value = btn.attr('data-value');
    }
    if (typeof (btn.attr('data-confirm')) !== 'undefined') {
        confirm = btn.attr('data-confirm');
    }
    var config = {
        title: title,
        formType: type,
        value: value,
        maxlength: max,
        btnAlign: 'c',
        cancel: function () { //右上角关闭回调
            btn.prop('disabled', false);
        },
        btn2: function (index, layero) {
            btn.prop('disabled', false);
            layer.close(index);
        }
    };
    layer.prompt(config, function (value, index) {
        layer.close(index);
        message = message.replace('{value}', value);
        var params = 'value=' + value;
        if (confirm) {
            layer.confirm(message, {time: 0, btnAlign: 'c'},
                    function (index) {
                        layer.close(index);
                        _ajax(btn, params);
                    });
        } else {
            _ajax(btn, params);
        }
        return false;
    });
}
//iframe层-父子操作 url title is_full
function iframeDialog(url, title) {
    var is_full = false;
    if (arguments.length === 3) {
        is_full = true;
    }
    //宽770px 显示滚动条样式 高570px 显示十行数据
    var config = {
        type: 2,
        title: title,
        area: ['770px', '570px'],
        maxmin: true,
        content: url
    };
    var index = layer.open(config);
    if (is_full) {
        layer.full(index);
    }
}
//ajax操作确认消息对话框
function confirmDialog(btn) {
    var message = '确认 ' + btn.text() + ' 操作吗？';
    if (typeof (btn.attr('data-message')) !== 'undefined') {
        message = btn.attr('data-message');
    }
    layer.msg(message, {
        time: 0, //不自动关闭
        btn: ['确定', '关闭'],
        btnAlign: 'c',
        yes: function (index) {
            layer.close(index);
            _ajax(btn);
            return false;
        },
        cancel: function () {
            btn.prop('disabled', false);
        },
        btn2: function () {
            btn.prop('disabled', false);
        }
    });
}
//ajax批量操作确认消息对话框
function confirmDialogAll(btn) {
    var message = '确认 ' + btn.text() + ' 操作吗？';
    if (typeof (btn.attr('data-message')) !== 'undefined') {
        message = btn.attr('data-message');
    }
    layer.msg(message, {
        time: 0, //不自动关闭
        btn: ['确定', '关闭'],
        btnAlign: 'c',
        yes: function (index) {
            layer.close(index);
            _ajax(btn, 'id=' + getValues());
            return false;
        },
        cancel: function () {
            btn.prop('disabled', false);
        },
        btn2: function () {
            btn.prop('disabled', false);
        }
    });
}
//表单提交
function checkForm() {
    if ($('.form-ajax').length > 0) {
        var target = '#showmsg';//错误信息需要显示ID
        $('.form-ajax').validator({
            target: target, //自定义消息的显示位置
            stopOnError: true, //在第一次错误时停止验证
            focusCleanup: true //输入框获得焦点时清除验证消息
        });
        $('.form-ajax').on('valid.form', function (e, form) {
            var btn = $(form).find('button[type=submit]').last();
            btn.prop('disabled', true);
            layer.msg('加载中...', {icon: 16, shade: 0.01, time: 0});
            //console.log($(form).serialize());
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: $(form).prop('action'),
                data: getCsrf() + '&' + $(form).serialize(),
                success: ajaxSuccess(btn),
                error: ajaxError(btn)
            });
            return false;
        });
        //未找到显示错误ID则使用弹窗显示错误信息
        $('.form-ajax').on('invalid.form', function (e, form, errors) {
            if ($(target).length === 0) {
                showDialog(errors[0]);
            }
        });
    }
}
//获取选中选项的值 jquery 1.6版本以上使用 prop属性操作
function getValues() {
    var val = [];
    $('tbody.checkbox_list :checkbox').each(function (i) {
        if ($(this).prop('checked')) {
            val.push($(this).val());
        }
    });
    return val.join(',');
}
//全选与不全选
function allCheck() {
    var chknum = $('tbody.checkbox_list :checkbox').size();//选项总个数 
    var num = 0;
    $('tbody.checkbox_list :checkbox').each(function () {
        if ($(this).prop('checked')) {
            num++;
        }
    });
    if (chknum === num) {
        $('.btn_all').prop('checked', true);//全选 
    } else {
        $('.btn_all').prop('checked', false);//不全选 
    }
}
$(function () {
    checkForm();
    //自定义内容操作
    $('.btn-open').click(function () {
        $(this).prop('disabled', true);
        openSelectDialog($(this));
    });
    //确认操作
    $('.btn-confirm').click(function () {
        $(this).prop('disabled', true);
        confirmDialog($(this));
    });
    //prompt操作
    $('.btn-prompt').click(function () {
        $(this).prop('disabled', true);
        promptDialog($(this));
    });
    //显示与隐藏 多个
    $('.showhide').click(function () {
        //例子 class="showhide" value="1" data-show="1|show_1|show_2,2|show_3|show_4" data-hide="1|hide_1|hide_2,2|hide_3|hide_4" 
        var show_name = 'data-show';
        var hide_name = 'data-hide';
        var val = $(this).val();
        if (typeof ($(this).attr(show_name)) !== 'undefined') {
            var values = $(this).attr(show_name).split(',');//格式化数组 values = ['1|show_1|show_2','2|show_3|show_4']
            for (var i in values) {
                var _values = values[i].split('|');//格式化数组 _values = ['1','show_1','show_2']
                var _value = _values[0];//获取第一个元素的值 = 1
                _values.splice(0, 1);//删除第一个元素 //_values = ['show_1','show_2']
                for (var _i in _values) {
                    if (val === _value) {
                        $('.' + _values[_i]).show();//.show_1.show()
                    }
                }
            }
        }
        if (typeof ($(this).attr(hide_name)) !== 'undefined') {
            var values = $(this).attr(hide_name).split(',');//格式化数组 values = ['1|hide_1|hide_2','2|hide_3|hide_4']
            for (var i in values) {
                var _values = values[i].split('|');//格式化数组 _values = ['1','hide_1','hide_2']
                var _value = _values[0];//获取第一个元素的值 = 1
                _values.splice(0, 1);//删除第一个元素 //_values = ['hide_1','hide_2']
                for (var _i in _values) {
                    if (val === _value) {
                        $('.' + _values[_i]).hide();//.hide_1.hide()
                    }
                }
            }
        }
    });
    //显示与隐藏 单个
    $('.show-hide').click(function () {
        var id = $(this).attr('data-showhide');
        //console.log(id);
        $('#' + id).toggle();
    });
    //全选或全不选 
    $('.btn_all').click(function () {
        if ($(this).prop('checked')) {
            $('tbody.checkbox_list :checkbox').prop('checked', true);
        } else {
            $('tbody.checkbox_list :checkbox').prop('checked', false);
        }
    });
    //设置全选复选框 
    $('tbody.checkbox_list :checkbox').click(function () {
        allCheck();
    });
    //批量确认操作
    $('.btn-confirm-all').click(function () {
        if (getValues()) {
            $(this).prop('disabled', true);
            confirmDialogAll($(this));
        }
    });
});