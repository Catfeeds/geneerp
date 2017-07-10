<?php

namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use common\extensions\CheckRule;
use backend\models\AdminRoute;

class Menu extends Widget {

    public function run() {
        $route = Yii::$app->controller->getRoute();
        $menu = AdminRoute::getTreeCache();
        $html = '';
        foreach ($menu as $v) {
            if (isset($v['sub']) && $v['c_parent_id'] == 0 && $v['c_status'] == 1) {
                //先全部隐藏最顶级，再添加标识，最后根据标识判断显示
                $show_menu_class = CheckRule::checkSubUrl($route, $v['sub']) ? ' show_menu_class' : '';
                $html .= '<ul class="sidebar-menu hide' . $show_menu_class . '">';
                foreach ($v['sub'] as $vv) {
                    //二级菜单判断
                    if (isset($vv['sub']) && $vv['c_status'] == 1) {
                        $_active = CheckRule::checkSubUrl($route, $vv['sub']);
                        $icon = $vv['c_icon'] ? : 'th-list';
                        $html .= '<li class="treeview' . ($_active ? ' active' : '' ) . '"><a href="javascript:;">' . '<i class="glyphicon glyphicon-' . $icon . '"></i> ' . '<span>' . $vv['c_title'] . '</span><span class="pull-right-container"><i class="glyphicon glyphicon-menu-left pull-right"></i></span></a>';
                        $html .= '<ul class="treeview-menu' . ($_active ? ' menu-open' : '' ) . '">';
                        foreach ($vv['sub'] as $vvv) {
                            if (CheckRule::checkRole($vvv['c_route']) && $vvv['c_status'] == 1) {
                                $icon = $vvv['c_icon'] ? : 'th-list';
                                $selectstr = $route == $vvv['c_route'] ? ' class="active"' : '';
                                $html .= '<li' . $selectstr . '><a href="' . Url::to([$vvv['c_route']]) . '">' . '<i class="glyphicon glyphicon-' . $icon . '"></i> ' . $vvv['c_title'] . '</a></li>';
                            }
                        }
                        $html .='</ul>';
                    }
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
        }
        return $html;
    }

}
