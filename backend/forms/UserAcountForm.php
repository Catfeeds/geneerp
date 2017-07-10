<?php

namespace backend\forms;

use yii\base\Model;
use common\models\User;
use common\models\UserAcount;
use common\models\UserAcountLog;

class UserAcountForm extends Model {

    public $user_id;
    public $amount;
    public $frozen_amount;
    public $point;
    public $exp;
    public $type;

    public function rules() {
        return [
            [['amount', 'frozen_amount', 'point', 'exp'], 'trim'],
            [['amount', 'frozen_amount', 'point', 'exp'], 'integer', 'skipOnEmpty' => true],
            [['user_id', 'type'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'amount' => '现金账户金额',
            'frozen_amount' => '冻结账户金额',
            'point' => '用户积分',
            'exp' => '用户经验值',
            'type' => '处理类型'
        ];
    }

    public function amount() {
        if ($this->type) {
            $type = $this->type == User::STATUS_YES ? UserAcountLog::ACOUNT_ADMIN_ADD : UserAcountLog::ACOUNT_ADMIN_SUB;
            if ($this->amount || $this->frozen_amount) {
                $result = UserAcount::cash($this->user_id, $type, User::CREATE_ADMIN, ['amount_money' => $this->amount, 'frozen_money' => $this->frozen_amount], $this->type);
                if ($result !== true) {
                    return $result;
                }
            }
            if ($this->point || $this->exp) {
                $result = UserAcount::point($this->user_id, $type, User::CREATE_ADMIN, ['point' => $this->point, 'exp' => $this->exp], $this->type);
                if ($result !== true) {
                    return $result;
                }
            }
            return true;
        }
        return false;
    }

}
