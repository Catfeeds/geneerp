<?php

namespace common\messages;

class Common {

    /**
     * 系统错误1000-1099
     */
    const SYSTEM_ERROR = 1000; //系统错误
    const SYSTEM_PARAMETER_ERROR = 1001; //参数错误
    const SYSTEM_PARAMETER_EMPTY = 1002; //参数不能为空
    const SYSTEM_PERMISSION_DENIED = 1003; //权限不足
    const SYSTEM_OPERATION_FAIL = 1004; //操作失败
    const SYSTEM_OPERATION_SUCCESS = 1005; //操作成功
    const SYSTEM_DATA_EMPTY = 1006; //信息获取失败
    const SYSTEM_WRITABLE_FAIL = 1007; //文件写入失败
    const SYSTEM_LOAD_FAIL = 1008; //数据加载出错，请检查模板中的模型名称是否正确
    /**
     * 手机号错误 1100-1199
     */
    const MOBILE_FORMAT_ERROR = 1100; //手机号格式错误
    const MOBILE_EXISTS = 1101; //手机号已经注册
    const MOBILE_NOT_EXISTS = 1102; //手机号不存在
    const MOBILE_TEST_NOT_EXISTS = 1103; //现在是测试阶段，如果需要测试请联系管理员
    const MOBILE_FORMAT_INPUT_ERROR = 1104; //请输入手机号11位数字
    const MOBILE_REGISTER = 1105; //手机号可以注册

    /**
     * 用户名错误1200-1299
     */
    const USER_PASSWORD_ERROR = 1200; //用户名或密码错误
    const ADMIN_STATUS_ERROR = 1201; //操作员登录状态已锁定，请联系管理员
    const USER_NOT_EXISTS = 1202; //用户名不存在
    const USER_EXISTS = 1203; //用户名已存在
    const USER_FORMAT_ERROR = 1204; //请输入手机号/邮箱/用户名
    const ACCOUNTS_FORMAT_ERROR = 1205; //请输入手机号/邮箱/用户名
    const ACCOUNTS_PASSWORD_ERROR = 1206; //账号或密码错误
    const ACCOUNTS_NOT_EXISTS = 1207; //账号不存在
    const USER_STATUS_ERROR = 1208; //用户状态已锁定

    /**
     * 密码错误1300-1399
     */
    const PASSWORD_FORMAT_ERROR = 1300; //请输入密码6-20位字符
    const PASSWORD_EMPTY = 1301; //密码不能为空
    const PASSWORD_CONFIRM_ERROR = 1302; //请确保两次密码输入一致
    const PASSWORD_OLD_ERROR = 1303; //请输入原密码6-20位字符
    const PASSWORD_SHOW_EMPTY = 1304; //不修改密码请留空
    const PASSWORD_OLD_CHECK_FAIL = 1305; //原密码验证失败

    /**
     * 真实姓名1400-1499
     */
    const REALNAME_FORMAT_ERROR = 1400; //请输入真实姓名2-4位字符

    /**
     * 邮箱1500-1599
     */
    const EMAIL_FORMAT_ERROR = 1500; //请正确输入邮箱
    const EMAIL_EXISTS = 1501; //邮箱已存在
    const EMAIL_NOT_EXISTS = 1502; //邮箱不存在
    /**
     * 验证码错误 1600-1699
     */
    const CAPTCHA_FORMAT_ERROR = 1600; //验证码格式错误
    const CAPTCHA_DATA_EMPTY = 1601; //验证码不能为空
    const CAPTCHA_CHECK_FAIL = 1602; //验证码错误
    const CAPTCHA_CHECK_SUCCESS = 1603; //验证码正确
    /**
     * 邮箱 2100-2199
     */
    const EMAIL_CODE_SEND_FAIL = 2100; //邮箱校验码发送失败
    const EMAIL_CODE_SEND_SUCCESS = 2101; //邮箱校验码发送成功
    const EMAIL_CODE_CHECK_FAIL = 2102; //邮箱校验码验证失败
    const EMAIL_CODE_CHECK_SUCCESS = 2103; //邮箱校验码验证成功
    const EMAIL_CODE_NOT_EXISTS = 2104; //邮箱校验码已过期，请重新获取。
    const EMAIL_CODE_FAST = 2105; //邮箱校验码发送频率过快。
    const EMAIL_CODE_TOO_MANY_TIMES = 2106; //邮箱校验码发送次数过多。
    const EMAIL_CODE_IP_TOO_MANY_TIMES = 2107; //当前IP邮箱校验码发送次数过多。
    const EMAIL_CODE_TEMPLATE_NOT_EXISTS = 2108; //邮箱校验码模板不存在。
    /**
     * 短信 2200-2299
     */
    const SMS_CODE_SEND_FAIL = 2200; //短信验证码发送失败
    const SMS_CODE_SEND_SUCCESS = 2201; //短信验证码发送成功
    const SMS_CODE_CHECK_FAIL = 2202; //短信验证码验证失败
    const SMS_CODE_CHECK_SUCCESS = 2203; //短信验证码验证成功
    const SMS_CODE_NOT_EXISTS = 2204; //短信验证码已过期，请重新获取。
    const SMS_CODE_FAST = 2205; //短信验证码发送频率过快。
    const SMS_CODE_TOO_MANY_TIMES = 2206; //短信验证码发送次数过多。
    const SMS_CODE_IP_TOO_MANY_TIMES = 2207; //当前IP短信验证码发送次数过多。
    const SMS_CODE_TEMPLATE_NOT_EXISTS = 2208; //短信模板不存在。
    /**
     * 公共验证 2000-2099
     */
    const COMMON_TITLE_EXISTS = 9000; //名称已存在
    const COMMON_TITLE_FORMAT_ERROR = 9001; //请输入名称2-50位字符
    const COMMON_TITLE_FORMAT_ERROR_255 = 9003; //请输入名称2-255位字符
    const COMMON_TITLE_FORMAT_ERROR_60 = 9004; //请输入名称2-60位字符
    const COMMON_PARENT_ID = 9005; //不可以选择自己为父级菜单
    const COMMON_SUB_ID = 9006; //不可以选择自己子类为父级菜单
    const COMMON_ARRAY_REPEAT = 9007; //该数组有重复值
    const COMMON_SUB_DELETE_FAIL = 9008; //请先删除本条记录的子类后再删除

}
