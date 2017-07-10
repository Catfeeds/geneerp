<?php

namespace common\extensions;

use Yii;

class SendSms {

    /**
     * 阿里大于发送短信 先再阿里大于后台设置模板和签名
     * 接口文档 https://api.alidayu.com/doc2/apiDetail.htm?spm=a3142.8062534.3.3.RjLEZX&apiId=25450
     * @param string $mobile 短信接收号码 支持单个或多个手机号，传入号码为11位手机号，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，一次调用最多传入200个号码。示例：18600000000,13911111111,13322222222
     * @param array $param  短信模板变量 传参规则{"key":"value"}，key的名字须和申请模板中的变量名一致，多个变量之间以逗号隔开。示例：针对模板“验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！”，传参时需传入{"code":"1234","product":"alidayu"}
     * @param string $sign_name 短信签名 传入的短信签名必须是在阿里大于“管理中心-短信签名管理”中的可用签名。如“阿里大于”已在短信签名管理中通过审核，则可传入”阿里大于“（传参时去掉引号）作为短信签名。短信效果示例：【阿里大于】欢迎使用阿里大于服务。
     * @param string $template_code  短信模板ID 传入的模板必须是在阿里大于“管理中心-短信模板管理”中的可用模板。示例：SMS_585014
     * @return object 
     */
    public static function send($mobile, $param, $sign_name, $template_code) {
        include_once Yii::getAlias('@common') . '/extensions/alidayu/TopSdk.php';
        $c = new \TopClient;
        $c->appkey = Yii::$app->params['sms_app_key'];
        $c->secretKey = Yii::$app->params['sms_app_secret'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType('normal');
        $req->setSmsFreeSignName($sign_name);
        $req->setSmsParam(json_encode($param));
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode($template_code);
        $resp = $c->execute($req);
        return json_decode(json_encode($resp, JSON_UNESCAPED_UNICODE), true);
    }

}
