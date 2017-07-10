<?php

namespace backend\models;

use Yii;
use common\models\_CommonModel;

/**
 * This is the model class for table "{{%admin_operation_log}}".
 *
 * @property string $c_id
 * @property string $c_admin_name
 * @property string $c_route
 * @property string $c_data_before
 * @property string $c_data_add
 * @property integer $c_type
 * @property integer $c_status
 * @property string $c_admin_id
 * @property string $c_object_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class AdminOperationLog extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%admin_operation_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_data_before', 'c_data_add'], 'string'],
            [['c_type', 'c_status', 'c_admin_id', 'c_object_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_admin_name'], 'string', 'max' => 20],
            [['c_route'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_admin_name' => '管理员用户名',
            'c_route' => '路由',
            'c_data_before' => '更新或删除前数据',
            'c_data_add' => '新增的数据',
            'c_type' => '操作类型',
            'c_status' => '状态',
            'c_admin_id' => '管理员ID',
            'c_object_id' => '操作的对象ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

    public function getAdminRoute() {
        return $this->hasOne(AdminRoute::className(), ['c_route' => 'c_route']);
    }

    public static function add($data) {
        $model = new AdminOperationLog();
        $model->attributes = $data;
        $model->c_admin_id = Yii::$app->user->identity->c_id;
        $model->c_admin_name = Yii::$app->user->identity->c_admin_name;
        $model->c_create_time = time();
        return $model->save();
    }

}
