<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%feedback_text}}".
 *
 * @property string $c_feedback_id
 * @property string $c_content
 * @property string $c_reply_content
 */
class FeedbackText extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%feedback_text}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_feedback_id'], 'required'],
            [['c_feedback_id'], 'integer'],
            [['c_content', 'c_reply_content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_feedback_id' => '反馈ID',
            'c_content' => '反馈内容',
            'c_reply_content' => '回复内容',
        ];
    }

    public static function addEdit($id, $data) {
        $model = FeedbackText::findOne($id);
        if (empty($model)) {
            $data['c_feedback_id'] = $id;
            $model = new FeedbackText();
        }
        $model->attributes = $data;
        return $model->save();
    }

}
