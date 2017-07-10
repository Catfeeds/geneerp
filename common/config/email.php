<?php

$config = require(__DIR__ . '/config.php');
//加密方式登录鉴权
$encryption = null;
if ($config['email_safe'] === '1') {
    $encryption = 'ssl';
} elseif ($config['email_safe'] === '2') {
    $encryption = 'tls';
}
return [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false, //true 在runtime目录下生成邮件，不会发送，用于测试
    'transport' => [
        'class' => $config['smtp_type'] === '1' ? 'Swift_SmtpTransport' : 'Swift_MailTransport',
        'host' => $config['email_smtp'],
        'username' => $config['smtp_user'],
        'password' => $config['smtp_password'], //lmvlsjobsoenbgdc
        'port' => (int) $config['smtp_port'],
        'encryption' => $encryption,
    ],
    'messageConfig' => [
        'charset' => 'UTF-8',
        'from' => [$config['email_send'] => $config['site_title']]
    ],
];
