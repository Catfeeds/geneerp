<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\extensions\Util;
use common\extensions\Tree;

class _CommonModel extends \yii\db\ActiveRecord {

    //删除状态
    const DELETE_NORMAL = 1; //正常状态
    const DELETE_DELETE = 2; //删除状态
    const DELETE_REMOVE = 3; //彻底删除状态
    //结果类型
    const RESULT_SUCCESS = 1; //日志操作成功
    const RESULT_FAIL = 2; //日志操作失败
    //操作类型
    const OPERATION_ADD = 1; //新增
    const OPERATION_UPDATE = 2; //更新
    const OPERATION_DELETE = 3; //删除
    //来源类型
    const CREATE_PC = 1; //PC
    const CREATE_H5 = 2; //H5
    const CREATE_IOS = 3; //IOS
    const CREATE_ANDRIOD = 4; //Andriod
    const CREATE_API = 7; //API
    const CREATE_OTHER = 8; //其他
    const CREATE_ADMIN = 9; //后台
    //状态
    const STATUS_YES = 1; //正常
    const STATUS_NO = 2; //无效
    const SELECT_STRING = ' ├ ';

    /**
     * 获取来源类型
     * @param type $type
     * @return type
     */
    public static function getCreateType($type = null) {
        $array = [
            self::CREATE_PC => 'PC',
            self::CREATE_H5 => 'H5',
            self::CREATE_IOS => 'IOS',
            self::CREATE_ANDRIOD => 'Andriod',
            self::CREATE_API => 'API',
            self::CREATE_OTHER => '其他',
            self::CREATE_ADMIN => '后台'
        ];
        return Util::getStatusText($type, $array);
    }

    /**
     * 获取操作类型
     * @param type $type
     * @return type
     */
    public static function getType($type = null) {
        $array = [
            self::OPERATION_ADD => '新增',
            self::OPERATION_UPDATE => '编辑',
            self::OPERATION_DELETE => '删除'
        ];
        return Util::getStatusText($type, $array);
    }

    /**
     * 获取删除状态
     * @param type $type
     * @return type
     */
    public static function getDeleteStatus($type = null) {
        $array = [
            self::DELETE_NORMAL => '正常',
            self::DELETE_DELETE => '已删除',
            self::DELETE_REMOVE => '已彻底删除'
        ];
        return Util::getStatusText($type, $array);
    }

    /**
     * 按sort排序查找
     * @param array $where
     * @param boolean $get_array
     * @param int $limit
     * @return object||array
     */
    public static function findSort($where = null, $get_array = false, $limit = null) {
        $model = static::find();
        $model->orderBy(['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]);
        if ($where) {
            $model->where($where);
        }
        if ($limit) {
            $model->limit($limit);
        }
        if ($get_array) {
            return $model->asArray()->all();
        }
        return $model->all();
    }

    public static function findSortCache($where = null, $get_array = false, $limit = null, $cache_time = 0) {
        $name = md5(get_called_class() . json_encode(func_get_args()));
        $data = self::getCache($name);
        if (empty($data)) {
            $data = static::findSort($where, $get_array, $limit);
            self::setCache($name, $data, $cache_time);
        }
        return $data;
    }

    /**
     * 按id 排序查找
     * @param array $where
     * @param boolean $get_array
     * @param int $limit
     * @return object||array
     */
    public static function findId($where = null, $get_array = false, $limit = null) {
        $model = static::find();
        $model->orderBy(['c_id' => SORT_DESC]);
        if ($where) {
            $model->where($where);
        }
        if ($limit) {
            $model->limit($limit);
        }
        if ($get_array) {
            return $model->asArray()->all();
        }
        return $model->all();
    }

    public static function findIdCache($where = null, $get_array = false, $limit = null, $cache_time = 0) {
        $name = md5(get_called_class() . json_encode(func_get_args()));
        $data = self::getCache($name);
        if (empty($data)) {
            $data = static::findId($where, $get_array, $limit);
            self::setCache($name, $data, $cache_time);
        }
        return $data;
    }

    public static function findOneCache($id, $cache_time = 0) {
        $name = md5(get_called_class() . json_encode(func_get_args()));
        $data = self::getCache($name);
        if (empty($data)) {
            $data = static::findOne($id);
            self::setCache($name, $data, $cache_time);
        }
        return $data;
    }

    /**
     * 返回某列数据
     * @param type $value_name
     * @param type $where
     * @return type
     */
    public static function getColumn($value_name, $where = null) {
        $data = static::findId($where, true);
        return ArrayHelper::getColumn($data, $value_name);
    }

    /**
     * 返回制定的键对值
     * @param array $where
     * @param string $value_name
     * @param string $key_name
     * @return array
     */
    public static function getKeyValue($where = null, $value_name = 'c_title', $key_name = 'c_id') {
        $data = static::findId($where, true);
        return ArrayHelper::map($data, $key_name, $value_name);
    }

    public static function getKeyValueCache($where = null, $value_name = 'c_title', $key_name = 'c_id', $cache_time = 0) {
        $name = md5(get_called_class() . json_encode(func_get_args()));
        $data = self::getCache($name);
        if (empty($data)) {
            $data = static::getKeyValue($where, $value_name, $key_name);
            self::setCache($name, $data, $cache_time);
        }
        return $data;
    }

    /**
     * 返回制定的键对值
     * @param array $where
     * @param string $value_name
     * @param string $key_name
     * @return array
     */
    public static function getKeyValueSort($where = null, $value_name = 'c_title', $key_name = 'c_id') {
        $data = static::findSort($where, true);
        return ArrayHelper::map($data, $key_name, $value_name);
    }

    public static function getKeyValueSortCache($where = null, $value_name = 'c_title', $key_name = 'c_id', $cache_time = 0) {
        $name = md5(get_called_class() . json_encode(func_get_args()));
        $data = self::getCache($name);
        if (empty($data)) {
            $data = static::getKeyValueSort($where, $value_name, $key_name);
            self::setCache($name, $data, $cache_time);
        }
        return $data;
    }

    /**
     * 返回树形数组
     * @param type $where
     * @return type
     */
    public static function getTree($where = null, $orderby = ['c_parent_id' => SORT_ASC, 'c_sort' => SORT_DESC]) {
        $model = static::find();
        $model->orderBy($orderby);
        if ($where) {
            $model->where($where);
        }
        $data = $model->asArray()->all();
        return Tree::getTree($data);
    }

    public static function getTreeCache($where = null, $cache_time = 0, $orderby = ['c_parent_id' => SORT_ASC, 'c_sort' => SORT_DESC]) {
        $name = md5(get_called_class() . json_encode(func_get_args()));
        $data = self::getCache($name);
        if (empty($data)) {
            $data = static::getTree($where, $orderby);
            self::setCache($name, $data, $cache_time);
        }
        return $data;
    }

    /**
     * 格式化下拉数据
     * @param type $default
     * @param type $where
     * @param type $show_layer
     */
    public static function formatDropDownList($where = null, $show_layer = 2) {
        static $array = [];
        $data = static::getTree($where);
        foreach ($data as $item) {
            static::dropDownList($array, $item, $show_layer);
        }
        return $array;
    }

    /**
     * 格式化下拉数据
     * @param type $default
     * @param type $where
     * @param type $show_layer
     */
    public static function formatDropDownListCache($where = null, $show_layer = 2) {
        static $array = [];
        $data = static::getTreeCache($where);
        foreach ($data as $item) {
            static::dropDownList($array, $item, $show_layer);
        }
        return $array;
    }

    protected static function dropDownList(&$array, $item, $show_layer, $current_layer = 1) {
        $array[$item['c_id']] = str_repeat(self::SELECT_STRING, $current_layer - 1) . $item['c_title'];
        if (isset($item['sub']) && $current_layer < $show_layer) {
            foreach ($item['sub'] as $v) {
                static::dropDownList($array, $v, $show_layer, $current_layer + 1);
            }
        }
    }

    //获取所有子类ID
    public static function getSub($id) {
        static $array = [];
        $data = static::findSort(['c_parent_id' => $id]);
        if ($data) {
            foreach ($data as $v) {
                $array[] = $v['c_id'];
                static::getSub($v['c_id']);
            }
        }
        return $array;
    }

    //检查父ID是否在子类数组中
    public static function checkSub($id, $parent_id = 0) {
        $sub = static::getSub($id);
        return in_array($parent_id, $sub);
    }

    public static function checkModel($model, $default = '保存数据失败') {
        $error = $model->getFirstErrors();
        if ($error) {
            return array_values($error)[0];
        }
        return $default;
    }

    /**
     * 格式化查询时间段
     * @param type $time_field 搜索字段
     * @param type $start_time 开始时间
     * @param type $end_time 结束时间
     * @return string
     */
    public static function formatSearchTime($time_field, $start_time = null, $end_time = null) {
        $where = [];
        if ($start_time && empty($end_time)) {
            $where[] = ['>=', $time_field, strtotime($start_time)];
        } elseif (empty($start_time) && $end_time) {
            $where[] = ['<=', $time_field, strtotime($end_time) + 86400];
        } elseif ($start_time && $end_time && $start_time < $end_time) {
            $where[] = ['>=', $time_field, strtotime($start_time)];
            $where[] = ['<=', $time_field, strtotime($end_time) + 86400];
        } elseif ($start_time && $end_time && $start_time > $end_time) {//谁的日期大就当做结束日期，相反就是开始日期
            $where[] = ['>=', $time_field, strtotime($end_time)];
            $where[] = ['<=', $time_field, strtotime($start_time) + 86400];
        } elseif ($start_time && $start_time == $end_time) {
            $where[] = ['>=', $time_field, strtotime($start_time)];
            $where[] = ['<=', $time_field, strtotime($start_time) + 86400];
        }
        return $where;
    }

    public static function systemLog($e) {
        SystemLog::add($e->getMessage() . $e->getFile() . $e->getLine());
    }

    public static function getCache($name) {
        $cache = Yii::$app->redisCache;
        return $cache->get($name);
    }

    public static function setCache($name, $data, $cache_time = 0) {
        $cache = Yii::$app->redisCache;
        return $cache->set($name, $data, $cache_time);
    }

}
