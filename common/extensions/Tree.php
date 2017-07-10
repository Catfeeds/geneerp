<?php

namespace common\extensions;

class Tree {

    /**
     * 格式化树形数组
     * @param type $data 输入二位数组
     * @param type $config 字段映射配置
     * @return type
     */
    public static function getTree($data, $config = ['id' => 'c_id', 'pid' => 'c_parent_id']) {
        //解决下标不是1开始的问题
        $items = array();
        foreach ($data as $value) {
            $items[$value[$config['id']]] = $value;
        }

        //开始组装
        $tree = array();
        foreach ($items as $key => $item) {
            if ($item[$config['pid']] == 0) { //为0，则为1级分类
                $tree[] = &$items[$key];
            } else {
                if (isset($items[$item[$config['pid']]])) { //存在值则为二级分类
                    $items[$item[$config['pid']]]['sub'][] = &$items[$key]; //传引用直接赋值与改变
                } else { //至少三级分类 由于是传引用思想，这里将不会有值
                    $tree[] = &$items[$key];
                }
            }
        }
        return $tree;
    }

}
