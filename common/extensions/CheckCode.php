<?php

namespace common\extensions;

use Yii;

class CheckCode {

    /**
     * 生成验证码字符串
     * @param type $key
     * @param type $type 字符类型 1纯数字
     * @param type $len 长度
     * @param type $expire 过期时间单位秒
     * @return type
     */
    public static function generateCode($key, $type = 1, $len = 4, $expire = 300) {
        $code = Yii::$app->redis->get(self::setKey($key));
        if ($code) {
            //如果已存在，对此重新设置过期时间
            Yii::$app->redis->set(self::setKey($key), $code);
        } else {
            $code = String::randString($len, $type);
            Yii::$app->redis->set(self::setKey($key), $code);
        }
        Yii::$app->redis->expire(self::setKey($key), $expire);
        return $code;
    }

    /**
     * 生成验证码字符串 是否相等
     * @param string $key
     * @param string $code
     * @return bool 
     */
    public static function isEqual($key, $code) {
        //测试只要输入test
        if (YII_DEBUG && $code === 'test') {
            return true;
        }
        $check = Yii::$app->redis->get(self::setKey($key));
        if ($check && $check == $code) {
            self::deleteCode($key);
            return true;
        }
        return false;
    }

    public static function deleteCode($key) {
        Yii::$app->redis->del(self::setKey($key));
    }

    public static function getCode($key) {
        return Yii::$app->redis->get(self::setKey($key));
    }

    public static function setKey($key) {
        return '_jjcms_check_code_' . $key;
    }

}
