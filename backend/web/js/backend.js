/* global bootbox */

function S4() {
    return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
}
function getGuid() {
    return (S4() + S4() + '-' + S4() + '-' + S4() + '-' + S4() + '-' + S4() + S4() + S4());
}
function _ajax(btn, params) {
    var dialog = bootbox.dialog({
        title: '请稍等...',
        message: '<p>Loading...</p>'
    });
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: btn.attr('data-url'),
        data: params,
        success: function (result) {
            dialog.init(function () {
                var message = result.status === 1 ? '操作成功' : '操作失败';
                dialog.find('.modal-header h4').html(message);
                dialog.find('.bootbox-body').html('1秒后自动关闭');
                setTimeout(function () {
                    window.top.location.reload();
                }, 1000);
            });
        }, error: function (xhr) {
            dialog.init(function () {
                dialog.find('.modal-header h4').html('操作失败');
                dialog.find('.bootbox-body').html('发生错误 ' + xhr.responseText + ' 1秒后自动关闭');
            });
            setTimeout(function () {
                bootbox.hideAll();
            }, 1000);

        }
    });
}
function jqueryConfirm(btn, params) {
    bootbox.setLocale('zh_CN');
    bootbox.confirm({
        message: btn.attr('data-title'),
        callback: function (result) {
            if (result) {
                _ajax(btn, params);
            }
        }
    });
}
function bootboxConfirm(callback) {
    bootbox.setLocale('zh_CN');
    bootbox.confirm({
        message: '确认继续操作吗？',
        callback: callback
    });
}
function bootboxPromptCard(url) {
    bootbox.setLocale('zh_CN');
    bootbox.prompt({
        title: '请选择代金券新增数量',
        inputType: 'select',
        inputOptions: [
            {text: '请选择', value: ''},
            {text: '10张', value: '10'},
            {text: '20张', value: '20'},
            {text: '50张', value: '50'},
            {text: '100张', value: '100'},
            {text: '200张', value: '200'},
            {text: '500张', value: '500'},
            {text: '1000张', value: '1000'},
            {text: '5000张', value: '5000'}
        ],
        callback: function (result) {
            if (result) {
                var dialog = bootbox.dialog({
                    title: '请稍等...',
                    message: '<p>Loading...</p>'
                });
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: url,
                    data: {ajaxparams: result},
                    success: function (result) {
                        dialog.init(function () {
                            var message = result.status === 1 ? '操作成功' : '操作失败';
                            dialog.find('.modal-header h4').html(message);
                            dialog.find('.bootbox-body').html('1秒后自动关闭');
                            setTimeout(function () {
                                window.top.location.reload();
                            }, 1000);
                        });
                    }, error: function (xhr) {
                        dialog.init(function () {
                            dialog.find('.modal-header h4').html('操作失败');
                            dialog.find('.bootbox-body').html(xhr.statusText);
                        });
                    }
                });
            }
        }
    });
}

$(function () {
    //选择时间和日期
    if ($('.form-datetime').length > 0) {
        $('.form-datetime').datetimepicker({weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0, showMeridian: 1, format: 'yyyy-mm-dd hh:ii'});
    }
    //仅选择日期
    if ($('.form-date').length > 0) {
        $('.form-date').datetimepicker({language: 'zh-CN', weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, minView: 2, forceParse: 0, format: 'yyyy-mm-dd'});
    }
    //选择时间
    if ($('.form-time').length > 0) {
        $('.form-time').datetimepicker({language: 'zh-CN', weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 1, minView: 0, maxView: 1, forceParse: 0, format: 'hh:ii'});
    }
    $('.show_menu_class').removeClass('hide');
    //显示与隐藏 单个
    $('.show-hide').click(function () {
        var id = $(this).attr('data-showhide');
        $('#' + id).toggle();
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
    $('.btn-confirm').click(function () {
        jqueryConfirm($(this));
    });
});