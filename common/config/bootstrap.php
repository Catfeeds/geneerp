<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console'); //短信与邮件 控制台发送
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend'); //前台 www.domain.com
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend'); //后台 admin.domain.com
Yii::setAlias('@upload', dirname(dirname(__DIR__)) . '/upload'); //上传文件 file.domain.com
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api'); //API接口 api.domain.com
Yii::setAlias('@ssm', dirname(dirname(__DIR__)) . '/ssm');
