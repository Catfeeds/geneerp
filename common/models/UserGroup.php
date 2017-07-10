<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property string $c_id
 * @property string $c_title
 * @property string $c_icon
 * @property integer $c_discount
 * @property string $c_minexp
 * @property string $c_maxexp
 * @property string $c_sort
 * @property string $c_create_time
 * @property string $c_update_time
 */
class UserGroup extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_title', 'c_discount', 'c_sort', 'c_minexp', 'c_maxexp'], 'required'],
            [['c_discount', 'c_minexp', 'c_maxexp', 'c_sort', 'c_create_time'], 'integer'],
            [['c_update_time'], 'safe'],
            [['c_title'], 'string', 'max' => 20],
            [['c_icon'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => 'ID',
            'c_title' => '用户组名称',
            'c_icon' => '用户组等级图标',
            'c_discount' => '折扣率',
            'c_minexp' => '最小经验值',
            'c_maxexp' => '最大经验值',
            'c_sort' => '排序',
            'c_create_time' => '创建时间',
            'c_update_time' => '最后更新时间',
        ];
    }

}
