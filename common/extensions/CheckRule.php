<?php

namespace common\extensions;

use Yii;

class CheckRule {

    public static function isLogin() {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        return true;
    }

    public static function isAdmin() {
        if (self::checkAdminId(Yii::$app->user->id)) {
            return true;
        }
        return false;
    }

    //检查user_id是不是管理员
    public static function checkAdminId($admin_id) {
        if ($admin_id && isset(Yii::$app->params['admin_id']) && in_array($admin_id, Yii::$app->params['admin_id'])) {
            return true;
        }
        return false;
    }

    //检查子菜单中是否包含当前路径
    public static function checkSecond($id, $route, $sub) {
        foreach ($sub as $v) {
            if ($v['c_route'] == $route && $v['c_parent_id'] == $id) {
                return true;
            }
        }
        return false;
    }

    //检查子菜单中是否包含当前路径
    public static function checkSubUrl($route, $sub) {
        foreach ($sub as $v) {
            if (isset($v['c_route']) && $v['c_route'] == $route) {
                return true;
            }
            if (isset($v['sub'])) {
                if (self::checkSubUrl($route, $v['sub'])) {
                    return true;
                }
            }
        }
        return false;
    }

    //固定URL检测
    public static function checkAllowUrl($url) {
        $allow_url = ['site/login', 'site/test', 'site/error', 'site/captcha']; //不用登录可访问
        $login_url = ['site/index', 'site/logout', 'site/my-profile', 'site/my-password']; //必须登录可访问
        return in_array($url, $allow_url) || (self::isLogin() && in_array($url, $login_url));
    }

    //检测权限
    public static function checkRole($url) {
        return self::isAdmin() || self::checkAllowUrl($url) || (self::isLogin() && in_array($url, Yii::$app->user->identity->getRole()));
    }

}
