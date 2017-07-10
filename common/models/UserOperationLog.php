<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_operation_log}}".
 *
 * @property string $c_id
 * @property string $c_user_name
 * @property string $c_route
 * @property string $c_data_before
 * @property string $c_data_add
 * @property integer $c_type
 * @property integer $c_status
 * @property integer $c_create_type
 * @property string $c_user_id
 * @property string $c_object_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserOperationLog extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_operation_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_data_before', 'c_data_add'], 'string'],
            [['c_type', 'c_status', 'c_create_type', 'c_user_id', 'c_object_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_user_name'], 'string', 'max' => 20],
            [['c_route'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_user_name' => '用户名',
            'c_route' => '路由名称',
            'c_data_before' => '更新或删除之前的数据',
            'c_data_add' => '新增的数据',
            'c_type' => '操作类型',
            'c_status' => '状态',
            'c_create_type' => '来源类型', // 1PC 2H5 3IOS 4Andriod 8其他 9平台
            'c_user_id' => '用户ID',
            'c_object_id' => '操作的对象ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public static function add($data) {
        $model = new UserOperationLog();
        $model->attributes = $data;
        $model->c_user_id = Yii::$app->user->id;
        $model->c_user_name = Yii::$app->user->identity->c_user_name;
        $model->c_create_time = time();
        return $model->save();
    }

}
