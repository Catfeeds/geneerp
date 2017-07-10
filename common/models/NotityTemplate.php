<?php

namespace common\models;

use Yii;
use common\messages\Common;
use common\extensions\Util;
use common\extensions\CheckCode;
use common\extensions\SendSms;

/**
 * This is the model class for table "{{%notity_template}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_sms_template_code
 * @property string $c_sms_sign_name
 * @property string $c_email_subject
 * @property string $c_web_subject
 * @property string $c_sms_template
 * @property string $c_email_template
 * @property string $c_app_template
 * @property string $c_web_template
 * @property integer $c_status
 * @property integer $c_email_status
 * @property integer $c_sms_status
 * @property integer $c_app_status
 * @property integer $c_web_status
 * @property string $c_type
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class NotityTemplate extends _CommonModel {

    //发送验证码
    const CODE_LOGIN = 100; //手机号登录获取验证码
    const CODE_REGISTER = 101; //注册获取验证码
    const CODE_FIND_PASSWORD = 103; //找回密码获取验证码
    const CODE_CHANGE_MOBILE = 104; //手机号设置获取验证码
    const CODE_CHANGE_EMAIL = 105; //邮箱设置获取验证码
    //发送信息
    const NOTITY_REGISTER_SUCCESS = 200; //注册成功通知
    const NOTITY_CHANGE_EMAIL_SUCCESS = 201; //邮箱设置成功通知
    const NOTITY_CHANGE_MOBILE_SUCCESS = 202; //手机号设置成功通知
    const NOTITY_CHANGE_PASSWORD_SUCCESS = 203; //登录密码设置成功通知
    const NOTITY_CHANGE_PAY_PASSWORD_SUCCESS = 204; //支付密码设置成功通知

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return '{{%notity_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /**
             * 过滤左右空格
             */
            [['c_title', 'c_sms_template_code', 'c_sms_sign_name', 'c_email_subject', 'c_web_subject', 'c_sort'], 'filter', 'filter' => 'trim'],
            [['c_title', 'c_status', 'c_sort'], 'required'],
            [['c_sms_template', 'c_email_template', 'c_app_template', 'c_web_template'], 'string'],
            [['c_status', 'c_email_status', 'c_sms_status', 'c_app_status', 'c_web_status', 'c_type', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title', 'c_sms_template_code', 'c_sms_sign_name', 'c_email_subject', 'c_web_subject'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '模板描述',
            'c_sms_template_code' => '短信模板ID',
            'c_sms_sign_name' => '短信签名',
            'c_email_subject' => '邮件主题',
            'c_web_subject' => '站内信主题',
            'c_sms_template' => '短信发送模板',
            'c_email_template' => '邮件发送模板',
            'c_app_template' => 'APP推送模板',
            'c_web_template' => '站内信模板',
            'c_status' => '状态',
            'c_email_status' => '邮件状态',
            'c_sms_status' => '短信状态',
            'c_app_status' => 'APP状态',
            'c_web_status' => '站内信状态',
            'c_type' => '消息类型',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function getSendStatus($type = null) {
        $array = [1 => '成功', 2 => '失败', 3 => '未发送'];
        return Util::getStatusText($type, $array);
    }

    public static function getType($type = null) {
        $array = [
            self::CODE_LOGIN => '手机号登录获取验证码',
            self::CODE_REGISTER => '注册获取验证码',
            self::CODE_FIND_PASSWORD => '找回密码获取验证码',
            self::CODE_CHANGE_MOBILE => '手机号设置获取验证码',
            self::CODE_CHANGE_EMAIL => '邮箱设置获取验证码',
            self::NOTITY_REGISTER_SUCCESS => '注册成功通知',
            self::NOTITY_CHANGE_EMAIL_SUCCESS => '邮箱设置成功通知',
            self::NOTITY_CHANGE_MOBILE_SUCCESS => '手机号设置成功通知',
            self::NOTITY_CHANGE_PASSWORD_SUCCESS => '登录密码设置成功通知',
            self::NOTITY_CHANGE_PAY_PASSWORD_SUCCESS => '支付密码设置成功通知',
        ];
        return Util::getStatusText($type, $array);
    }

    /**
     * 获取验证码类型
     * @param type $code_type
     * @return type
     */
    public static function getCodeType($code_type = null) {
        $array = [
            'code_login' => self::CODE_LOGIN,
            'code_register' => self::CODE_REGISTER,
            'code_find_password' => self::CODE_FIND_PASSWORD,
            'code_change_mobile' => self::CODE_CHANGE_MOBILE,
            'code_change_email' => self::CODE_CHANGE_EMAIL,
        ];
        return Util::getStatusText($code_type, $array);
    }

    /*
     * *******************************邮件发送*******************************
     */

    /**
     * 发送邮箱校验码
     * @param type $code_type 消息类型
     * @param type $email 邮箱
     * @return boolean|string
     */
    public static function sendEmailCode($code_type, $email) {
        if (!array_key_exists($code_type, self::getCodeType())) {
            return '消息类型非法';
        }

        if (!Util::checkEmail($email)) {
            return Yii::t('common', Common::EMAIL_FORMAT_ERROR);
        }

        $check_exists = in_array($code_type, ['code_login', 'code_find_password']) ? true : false; //检测邮箱是否存在
        $model = User::existEmail($email);

        if ($model && $check_exists === false) {
            return Yii::t('common', Common::EMAIL_EXISTS);
        }

        if (!$model && $check_exists === true) {
            return Yii::t('common', Common::EMAIL_NOT_EXISTS);
        }

        try {
            //判断IP地址 超过十条，则不让发送
            $ip = Yii::$app->getRequest()->getUserIP();
            $ip_key = 'count_email_' . $ip; //每个IP在一天发送相同邮箱的总数
            $ip_value = (int) Yii::$app->redis->get($ip_key); //内容格式:2

            if ($ip_value > (int) Yii::$app->params['email_ip_count']) {
                return Yii::t('common', Common::EMAIL_CODE_IP_TOO_MANY_TIMES); //当前IP短信验证码发送次数过多
            } else {
                $ip_value++;
            }

            //如果在规定时间内超过设置值，则不让发送
            $total_key = 'count_email_' . $email; //每个邮箱当日发送总数
            $total_value = Yii::$app->redis->get($total_key); //内容格式:2|1456905576
            $total_count = 0;
            $time = time();
            if ($total_value) {
                $array = explode('|', $total_value);
                $total_count = (int) $array[0]; //当日发送总数
                $time = (int) $array[1]; //最后发送时间
                if (time() < $time) {
                    return Yii::t('common', Common::EMAIL_CODE_FAST); //需要检查每次需要60秒后重新获取验证码
                }
            }
            if ($total_count > (int) Yii::$app->params['email_send_count']) {
                return Yii::t('common', Common::EMAIL_CODE_TOO_MANY_TIMES); //短信验证码发送次数过多
            } else {
                $total_count++;
            }

            $param = Config::geteConfig();
            $param['username'] = isset($model->c_user_name) ? $model->c_user_name : $email;
            $param['code'] = CheckCode::generateCode($email, 1, 4, (int) Yii::$app->params['email_expire']); //生产一个4位验证码字符
            $type = NotityTemplate::getCodeType($code_type);
            $result = self::_sendEmailCode($type, $email, $param);
            if ($result === true) {
                Yii::$app->redis->set($ip_key, $ip_value); //记录用户IP短信数量
                Yii::$app->redis->expire($ip_key, 86400); //缓存24小时
                Yii::$app->redis->set($total_key, $total_count . '|' . (time() + (int) Yii::$app->params['email_send_time'])); //记录用户短信数量
                Yii::$app->redis->expire($total_key, 86400); //缓存24小时
                return true;
            } else {
                return Yii::t('common', Common::EMAIL_CODE_SEND_FAIL) . '，原因：' . $result;
            }
        } catch (\Exception $ex) {
            SystemLog::add($ex->getMessage());
            return $ex->getMessage();
        }
    }

    /**
     * 发送邮箱校验码
     * @param type $type 消息类型
     * @param type $email 邮箱
     * @param type $param 模板替换参数
     * @return boolean|string
     */
    private static function _sendEmailCode($type, $email, $param = []) {
        try {
            $model = static::findOne(['c_status' => self::STATUS_YES, 'c_email_status' => self::STATUS_YES, 'c_type' => $type]);
            if ($model) {
                if (empty($model->c_email_subject)) {
                    return '邮件主题不能为空';
                }
                if (empty($model->c_email_template)) {
                    return '邮件模板不能为空';
                }
                $body = $model->c_email_template;
                $subject = $model->c_email_subject;
                if ($param && is_array($param)) {
                    foreach ($param as $k => $v) {
                        $body = str_replace('${' . $k . '}', $v, $body);
                    }
                }

                $log_id = EmailLog::add($type, $email, $subject, $body, $param);

                if ($log_id) {
                    $array = ['id' => $log_id, 'email' => $email, 'subject' => $subject, 'body' => $body];
                    if (Yii::$app->params['email_send_type'] === '2') {
                        //队列发送 REDIS缓存 运行脚本执行发送
                        Yii::$app->redis->rpush('email', json_encode($array));
                        return true;
                    } else {
                        //直接发送
                        return self::commonSendEmail($array);
                    }
                } else {
                    return '邮件发送日志写入失败';
                }
            } else {
                return '消息类型对应模板未设置';
            }
        } catch (\Exception $ex) {
            SystemLog::add($ex->getMessage());
            return $ex->getMessage();
        }
    }

    /**
     * 发送邮件方法
     * @param type $array $array['email'],$array['subject'],$array['body']
     * @return type
     */
    public static function commonSendEmail($array) {
        try {
            $result = Yii::$app->mailer->compose()->setTo($array['email'])->setSubject($array['subject'])->setHtmlBody($array['body'])->send();
            $id = (int) $array['id'];
            if ($result === true) {
                //发送成功更新状态
                EmailLog::updateAll(['c_status' => self::STATUS_YES], ['c_id' => $id]);
                return true;
            } else {
                //记录发送错误信息
                EmailLog::updateAll(['c_status' => self::STATUS_NO, 'c_error' => $result], ['c_id' => $id]);
                return false;
            }
        } catch (\Exception $ex) {
            SystemLog::add($ex->getMessage());
            return $ex->getMessage();
        }
    }

    /*
     * *******************************短信发送*******************************
     */

    /**
     * 发送短信验证码
     * @param type $code_type 消息类型
     * @param type $mobile 手机号
     * @return boolean|string
     */
    public static function sendSmsCode($code_type, $mobile) {
        if (!array_key_exists($code_type, self::getCodeType())) {
            return '消息类型非法';
        }

        if (!Util::checkMobile($mobile)) {
            return Yii::t('common', Common::MOBILE_FORMAT_ERROR);
        }

        $check_exists = in_array($code_type, ['code_login', 'code_find_password']) ? true : false; //检测手机号是否存在
        $model = User::existMobile($mobile);

        if ($model && $check_exists === false) {
            return Yii::t('common', Common::MOBILE_EXISTS);
        }

        if (!$model && $check_exists === true) {
            return Yii::t('common', Common::MOBILE_NOT_EXISTS);
        }

        try {
            //判断IP地址 超过十条，则不让发送
            $ip = Yii::$app->getRequest()->getUserIP();
            $ip_key = 'count_sms_' . $ip; //每个IP在一天发送相同手机号的总数
            $ip_value = (int) Yii::$app->redis->get($ip_key); //内容格式:2

            if ($ip_value > (int) Yii::$app->params['sms_ip_count']) {
                return Yii::t('common', Common::SMS_CODE_IP_TOO_MANY_TIMES); //当前IP短信验证码发送次数过多
            } else {
                $ip_value++;
            }

            //如果在规定时间内超过设置值，则不让发送
            $total_key = 'count_sms_' . $mobile; //每个手机号当日发送总数
            $total_value = Yii::$app->redis->get($total_key); //内容格式:2|1456905576
            $total_count = 0;
            $time = time();
            if ($total_value) {
                $array = explode('|', $total_value);
                $total_count = (int) $array[0]; //当日发送总数
                $time = (int) $array[1]; //最后发送时间
                if (time() < $time) {
                    return Yii::t('common', Common::SMS_CODE_FAST); //需要检查每次需要60秒后重新获取验证码
                }
            }
            if ($total_count > (int) Yii::$app->params['sms_send_count']) {
                return Yii::t('common', Common::SMS_CODE_TOO_MANY_TIMES); //短信验证码发送次数过多
            } else {
                $total_count++;
            }
            $param = []; //短信获取验证码只有一个变量${code}
            $param['code'] = CheckCode::generateCode($mobile, 1, 4, (int) Yii::$app->params['sms_expire']); //生产一个4位验证码字符
            $type = NotityTemplate::getCodeType($code_type);
            $result = self::_sendSmsCode($type, $mobile, $param);
            if ($result === true) {
                Yii::$app->redis->set($ip_key, $ip_value); //记录用户IP短信数量
                Yii::$app->redis->expire($ip_key, 86400); //缓存24小时
                Yii::$app->redis->set($total_key, $total_count . '|' . (time() + (int) Yii::$app->params['sms_send_time'])); //记录用户短信数量
                Yii::$app->redis->expire($total_key, 86400); //缓存24小时
                return true;
            } else {
                return Yii::t('common', Common::SMS_CODE_SEND_FAIL) . '，原因：' . $result;
            }
        } catch (\Exception $ex) {
            SystemLog::add($ex->getMessage());
            return $ex->getMessage();
        }
    }

    /**
     * 发送短信验证码
     * @param type $type 消息类型
     * @param type $mobile 手机号
     * @param type $param 模板替换参数
     * @return boolean|string
     */
    private static function _sendSmsCode($type, $mobile, $param = []) {
        try {
            $model = static::findOne(['c_status' => self::STATUS_YES, 'c_sms_status' => self::STATUS_YES, 'c_type' => $type]);
            if ($model) {
                if (empty($model->c_sms_template)) {
                    return '短信模板不能为空';
                }
                if (empty($model->c_sms_sign_name)) {
                    return '短信签名不能为空';
                }
                if (empty($model->c_sms_template_code)) {
                    return '短信模板ID不能为空';
                }
                $body = $model->c_sms_template;

                if ($param && is_array($param)) {
                    foreach ($param as $k => $v) {
                        $body = str_replace('${' . $k . '}', $v, $body);
                    }
                }

                $log_id = SmsLog::add($type, $mobile, $body, $param);

                if ($log_id) {
                    $array = ['id' => $log_id, 'mobile' => $mobile, 'param' => $param, 'sign_name' => $model->c_sms_sign_name, 'template_code' => $model->c_sms_template_code];
                    if (Yii::$app->params['sms_send_type'] === '2') {
                        //队列发送 REDIS缓存 运行脚本执行发送
                        Yii::$app->redis->rpush('sms', json_encode($array));
                        return true;
                    } else {
                        //直接发送
                        return self::commonSendSms($array);
                    }
                } else {
                    return '短信发送日志写入失败';
                }
            } else {
                return '消息类型对应模板未设置';
            }
        } catch (\Exception $ex) {
            SystemLog::add($ex->getMessage());
            return $ex->getMessage();
        }
    }

    /**
     * 发送短信方法
     * @param type $array $array['mobile'],$array['param'],$array['sign_name'],$array['template_code']
     * @return type
     */
    public static function commonSendSms($array) {
        try {
            $result = SendSms::send($array['mobile'], $array['param'], $array['sign_name'], $array['template_code']);
            $status = isset($result['result']) ? true : false;
            $code = isset($result['code']) ? $result['code'] : '';
            $msg = isset($result['msg']) ? $result['msg'] : '';
            $sub_msg = isset($result['sub_msg']) ? $result['sub_msg'] : '';
            //更新数据
            $update_data = [];
            $update_data['c_status'] = $status ? self::STATUS_YES : self::STATUS_NO; //状态 1成功 2失败 3未发送
            $update_data['c_sms_request_id'] = isset($result['request_id']) ? $result['request_id'] : '';
            $update_data['c_sms_model'] = isset($result['result']['model']) ? $result['result']['model'] : '';
            $update_data['c_sms_msg'] = 'code: ' . $code . ' msg: ' . $msg . ' sub_msg: ' . $sub_msg;
            $update_data['c_sms_code'] = isset($result['sub_code']) ? $result['sub_code'] : '';
            SmsLog::updateAll($update_data, ['c_id' => (int) $array['id']]);
            return $status ? true : $sub_msg;
        } catch (\Exception $ex) {
            SystemLog::add($ex->getMessage());
            return $ex->getMessage();
        }
    }

    /**
     * 发送信息 可以发送多渠道 短信 邮件 站内信 APP推送还未实施
     * @param type $type
     * @param type $user_id
     * @return boolean
     */
    public static function sendNotify($type, $user_id) {
        try {
            $user = User::findOne($user_id);
            if (!$user) {
                return false;
            }
            $model = static::findOne(['c_status' => self::STATUS_YES, 'c_type' => $type]);
            if (!$model) {
                return false;
            }
            //发送短信息
            if ($user->c_mobile && $user->c_mobile_verify == User::VERIFY_YES && $model->c_sms_status == self::STATUS_YES && $model->c_sms_template && $model->c_sms_sign_name && $model->c_sms_template_code) {
                $body = $model->c_sms_template;
                //模板替换参数
                $param = [];
                $param['username'] = $user->c_user_name;
                foreach ($param as $k => $v) {
                    $body = str_replace('${' . $k . '}', $v, $body);
                }

                $log_id = SmsLog::add($type, $user->c_mobile, $body, $param);

                if ($log_id) {
                    $array = ['id' => $log_id, 'mobile' => $user->c_mobile, 'param' => $param, 'sign_name' => $model->c_sms_sign_name, 'template_code' => $model->c_sms_template_code];
                    if (Yii::$app->params['sms_send_type'] === '2') {
                        //队列发送 REDIS缓存 运行脚本执行发送
                        Yii::$app->redis->rpush('sms', json_encode($array));
                    } else {
                        //直接发送
                        self::commonSendSms($array);
                    }
                }
            }
            //发送邮件信息
            if ($user->c_email && $user->c_email_verify == User::VERIFY_YES && $model->c_email_status == self::STATUS_YES && $model->c_email_subject && $model->c_email_template) {
                $body = $model->c_email_template;
                $param = Config::geteConfig();
                $param['username'] = $user->c_user_name;
                if ($param && is_array($param)) {
                    foreach ($param as $k => $v) {
                        $body = str_replace('${' . $k . '}', $v, $body);
                    }
                }

                $log_id = EmailLog::add($type, $user->c_email, $model->c_email_subject, $body, $param);

                if ($log_id) {
                    $array = ['id' => $log_id, 'email' => $user->c_email, 'subject' => $model->c_email_subject, 'body' => $body];
                    if (Yii::$app->params['email_send_type'] === '2') {
                        //队列发送 REDIS缓存 运行脚本执行发送
                        Yii::$app->redis->rpush('email', json_encode($array));
                    } else {
                        //直接发送
                        self::commonSendEmail($array);
                    }
                }
            }
            //发送站内信
            if ($model->c_web_status == self::STATUS_YES && $model->c_web_subject && $model->c_web_template) {
                $body = $model->c_web_template;
                $param = Config::geteConfig();
                $param['username'] = $user->c_user_name;
                if ($param && is_array($param)) {
                    foreach ($param as $k => $v) {
                        $body = str_replace('${' . $k . '}', $v, $body);
                    }
                }
                UserMessage::add($user_id, $model->c_web_subject, $body);
            }
            //APP推送接口TODO
            return true;
        } catch (\Exception $ex) {
            SystemLog::add($ex->getMessage());
            return $ex->getMessage();
        }
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->c_email_status = $this->c_email_status ? $this->c_email_status : self::STATUS_NO;
            $this->c_sms_status = $this->c_sms_status ? $this->c_sms_status : self::STATUS_NO;
            $this->c_app_status = $this->c_app_status ? $this->c_app_status : self::STATUS_NO;
            $this->c_web_status = $this->c_web_status ? $this->c_web_status : self::STATUS_NO;
            return true;
        }
        return false;
    }

}
