<?php

namespace backend\models;

use Yii;
use common\models\_CommonModel;
/**
 * This is the model class for table "{{%admin_role_node}}".
 *
 * @property string $c_id
 * @property integer $c_status
 * @property string $c_role_id
 * @property string $c_route_id
 * @property string $c_create_time
 * @property string $c_update_time
 */
class AdminRoleNode extends _CommonModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_role_node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['c_status', 'c_role_id', 'c_route_id', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'c_id' => '节点ID',
            'c_status' => '状态 1正常 2无效',
            'c_role_id' => '角色ID',
            'c_route_id' => '路由ID',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }
}
