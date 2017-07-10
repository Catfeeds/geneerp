<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property string $c_id
 * @property string $c_key
 * @property string $c_content
 */
class Config extends _CommonModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_key'], 'required'],
            [['c_content'], 'string'],
            [['c_key'], 'string', 'max' => 50],
            [['c_key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_id' => '自增主键',
            'c_key' => '配置键',
            'c_content' => '配置值',
        ];
    }

    public static function getConfigKeys() {
        return ['site', 'upload', 'shop', 'email', 'sms', 'plugin', 'system'];
    }

    public static function geteConfig() {
        return [
            'webname' => Yii::$app->params['site_title'],
            'website' => Yii::$app->params['domian_frontend'],
            'weixin' => Yii::$app->params['site_weixin'],
            'phone' => Yii::$app->params['site_phone'],
        ];
    }

    public static function getData($key = null) {
        $result = Config::find()->all();
        $data = [];
        if ($result) {
            foreach ($result as $v) {
                $data[$v->c_key] = $v->c_content ? json_decode($v->c_content, JSON_UNESCAPED_UNICODE) : '';
                if ($key && $key == $v->c_key) {
                    return $data[$v->c_key];
                }
            }
        }
        return $data;
    }

    public static function create() {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (self::moreAdd()) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return '保存数据失败';
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            self::systemLog($e);
            return $e->getMessage();
        }
    }

    private static function moreAdd() {
        $data = Yii::$app->request->post();
        $keys = self::getConfigKeys();
        foreach ($data as $k => $v) {
            if (in_array($k, $keys)) {
                if (!self::addEdit($k, $v)) {
                    return false;
                }
            }
        }
        return true;
    }

    private static function addEdit($key, $content) {
        $model = Config::findOne(['c_key' => $key]);
        if ($model) {
            $model->c_content = json_encode(array_map('trim', $content));
            return $model->save();
        } else {
            return self::add($key, $content);
        }
    }

    private static function add($key, $content) {
        $model = new Config();
        $model->c_key = $key;
        $model->c_content = json_encode(array_map('trim', $content));
        return $model->save();
    }

}
