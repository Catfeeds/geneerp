<?php

namespace common\models;

use Yii;
use common\extensions\Util;

class ShopCart extends \yii\db\ActiveRecord {

    public $user_id = 0; //用户ID
    public $group_id = 0; //用户组ID
    public $group_discount = 100; //用户组折扣
    public $error; //错误信息
    public $order_data; //结算后的需要写入订单的信息
    private $buy_data; //提交过来的商品ID 与 购买数量

    public function init($user_id = 0) {
        $this->order_data['weight'] = 0; //商品重量
        $this->order_data['type_count'] = 0; //订单商品种类数目
        $this->order_data['point'] = 0; //总积分
        $this->order_data['exp'] = 0; //总经验
        $this->order_data['card_amount'] = 0; //代金券面值
        $this->order_data['payable_goods_amount'] = 0; //应付商品总金额
        $this->order_data['paid_goods_amount'] = 0; //实付商品总金额
        $this->order_data['payable_freight_amount'] = 0; //应付运费
        $this->order_data['paid_freight_amount'] = 0; //实付运费
        $this->order_data['tax_amount'] = 0; //总税金
        $this->order_data['pay_fee_amount'] = 0; //支付手续费
        $this->order_data['insured_amount'] = 0; //保价金额
        $this->order_data['promotion_amount'] = 0; //促销优惠金额
        $this->order_data['payable_order_amount'] = 0; //应付订单总金额
        $this->order_data['order_amount'] = 0; //实付订单总金额
        $this->order_data['order_goods'] = []; //订单的商品详情
        if ($user_id) {
            $this->user_id = $user_id;
        }

        //获取用户组ID及组的折扣率
        if ($this->user_id) {
            $model = User::find($this->user_id)->with('userGroup')->one();
            if ($model) {
                $this->group_id = $model->c_group_id;
                $this->group_discount = $model->userGroup->c_discount;
            }
        }
    }

    /** 计算商品价格 
     * @param type $province_id 省份ID
     * @param type $delivery_id 配送方式ID
     * @param type $pay_type 支付ID
     * @param type $is_invoice 是否要发票 1需要 2不需要
     * @param type $paid_freight_amount 自定义运费
     * @param type $admin_discount_amount 平台增减金额 
     * @return type
     * 
     */
    public function checkOut($province_id, $delivery_id, $pay_type, $is_invoice = 2, $paid_freight_amount = null, $admin_discount_amount = 0) {
        $order_goods = [];
        $this->order_data['type_count'] = count($this->buy_data);
        if ($this->buy_data) {
            $goods_id_array = array_keys($this->buy_data);
            $goods_list = Goods::findId(['c_id' => $goods_id_array]);
            foreach ($goods_list as $v) {
                $count = $this->buy_data[$v->c_id]['buy_count']; //购买商品的数量

                if ($count <= 0 || $count > $v->c_store_count) {
                    $this->error = '商品：' . $v->c_title . ' 购买数量超出库存' . $v->c_store_count . $v->c_unit . '，请重新调整购买数量。';
                    $order_goods[$v->c_id]['title'] = $v->c_title . '【无库存或超出库存】';
                } else {
                    $order_goods[$v->c_id]['title'] = $v->c_title;
                }

                //应付商品总金额
                $this->order_data['payable_goods_amount'] += $count * $v->c_sell_price;
                //重量
                $this->order_data['weight'] += $count * $v->c_weight;
                //积分
                $this->order_data['point'] += $count * $v->c_point;
                //经验
                $this->order_data['exp'] += $count * $v->c_exp;
                //当前购买价格
                $current_price = $v->c_sell_price;
                //通过特定用户组获取购买价格
                $group_price = $this->getGroupPrice($v->c_id);

                if ($group_price) {
                    $current_price = $group_price;
                } else {
                    //通过会员组获取折扣价格 设置为当前购买价格
                    if ($this->group_discount) {
                        $current_price = Util::formatPrice($v->c_sell_price * $this->group_discount * 0.01);
                    }
                }
                //优惠
                $this->order_data['promotion_amount'] += ($v->c_sell_price - $current_price) * $count;
                //实付商品总金额
                $this->order_data['paid_goods_amount'] += $current_price * $count;
                $order_goods[$v->c_id]['real_price'] = $current_price; //购买商品真实价格
                $order_goods[$v->c_id]['goods_id'] = $v->c_id;
                $order_goods[$v->c_id]['point'] = $v->c_point;
                $order_goods[$v->c_id]['exp'] = $v->c_exp;
                $order_goods[$v->c_id]['number'] = $v->c_number;
                $order_goods[$v->c_id]['weight'] = $v->c_weight;
                $order_goods[$v->c_id]['sell_price'] = $v->c_sell_price;
                $order_goods[$v->c_id]['picture'] = Upload::getThumbOne($v->c_picture, false);
                $order_goods[$v->c_id]['buy_count'] = $count; //购买商品的数量
                $order_goods[$v->c_id]['store_count'] = $v->c_store_count; //原库存总量
            }
        }

        //只有开发票才计算税金
        if ($is_invoice == Order::STATUS_YES) {
            $this->order_data['tax_amount'] = $this->order_data['payable_goods_amount'] * (int) Yii::$app->params['shop_tax'] * 0.01;
        }

        //设置运费  促销活动规则免运费TODO
        if ($paid_freight_amount == null) {
            $this->getDeliveryPrice($delivery_id, $province_id);
        } else {
            $this->order_data['payable_freight_amount'] = $this->order_data['paid_freight_amount'] = Util::formatPrice($paid_freight_amount);
        }
        //设置支付费用
        $this->getPaymentPrice($pay_type);
        //优惠金额 
        $this->order_data['promotion_amount'] = $this->order_data['promotion_amount'] - $admin_discount_amount;
        //订单优惠 = (商品单价 - 折后价) * 数量 - 平台增减金额 + 活动优惠(免运费等)
        //应付订单总金额 = 应付商品总额 + 应付运费 + 保价 + 税率
        //实付订单总金额 = 实付商品总额 + 实际运费 + 保价 + 税率 - 商品优惠
        //支付手续费一般有商家自己支付 已记录方便以后使用 如营销联盟的返佣金结算时

        $this->order_data['payable_order_amount'] = $this->order_data['payable_goods_amount'] + $this->order_data['payable_freight_amount'] + $this->order_data['insured_amount'] + $this->order_data['tax_amount'];
        $this->order_data['order_amount'] = $this->order_data['paid_goods_amount'] + $this->order_data['paid_freight_amount'] + $this->order_data['insured_amount'] + $this->order_data['tax_amount'] - $this->order_data['promotion_amount'];
        $this->order_data['order_goods'] = $order_goods;
    }

    /**
     * 格式化数据
     * @param type $goods_ids
     * @param type $counts
     * @return type
     */
    public function dataFormat($goods_ids, $counts) {
        $goods_array = [];
        foreach ($goods_ids as $key => $goods_id) {
            $goods_array[$goods_id]['buy_count'] = $counts[$key];
        }
        $this->buy_data = $goods_array;
    }

    /**
      根据重量计算运费
     * @param type $weight 总重量
     * @param type $first_price 首重费用
     * @param type $second_price 次重费用
     * @param type $first_weight 首重
     * @param type $second_weight 次重
     * @return type
     */
    private function getFeeByWeight($weight, $first_price, $second_price, $first_weight, $second_weight) {
        //当商品重量小于或等于首重的时候
        if ($weight <= $first_weight) {
            return $first_price;
        }

        //当商品重量大于首重时，根据次重进行累加计算
        $num = ceil(($weight - $first_weight) / $second_weight);
        return $first_price + $second_price * $num;
    }

    /**
     * 计算运费
     * @param type $delivery_id
     * @param type $province_id
     * @param type $weight
     */
    private function getDeliveryPrice($delivery_id, $province_id) {
        $freight_amount = 0; //运费
        $row = Delivery::findOne($delivery_id);
        if ($row && $row->c_status == Delivery::STATUS_YES) {
            if ($row->c_price_type == 1) {
                $freight_amount = $this->getFeeByWeight($this->order_data['weight'], $row->c_first_price, $row->c_second_price, $row->c_first_weight, $row->c_second_weight);
            } else {
                if ($row->c_area_id_array) {
                    $area_id_array = json_decode($row->c_area_id_array, true);
                    $first_price_array = json_decode($row->c_first_price_array, true);
                    $second_price_array = json_decode($row->c_second_price_array, true);
                    foreach ($area_id_array as $k => $v) {
                        $province = explode(',', $v);
                        if (in_array($province_id, $province)) {
                            $freight_amount = $this->getFeeByWeight($this->order_data['weight'], $first_price_array[$k], $second_price_array[$k], $row->c_first_weight, $row->c_second_weight);
                            break;
                        }
                    }
                } else {
                    if ($row->c_open_default == Delivery::STATUS_YES) {
                        $freight_amount = $this->getFeeByWeight($this->order_data['weight'], $row->c_first_price, $row->c_second_price, $row->c_first_weight, $row->c_second_weight);
                    } else {
                        $this->error = '不支持配送';
                    }
                }
            }
            //计算保价
            $insured_amount = 0;
            if ($row->c_is_insured == Delivery::STATUS_YES) {
                $temp_price = $this->order_data['payable_goods_amount'] * $row->c_insured_rate * 0.01;
                $insured_amount = ($temp_price <= $row->c_low_price) ? $row->c_low_price : $temp_price;
            }
            $this->order_data['insured_amount'] = $insured_amount;
        }
        $this->order_data['payable_freight_amount'] = $this->order_data['paid_freight_amount'] = $freight_amount;
    }

    /**
     * 获取商品金额的支付费用
     * @param int $pay_type 支付方式ID
     * @return int
     */
    private function getPaymentPrice($pay_type) {
        $pay_fee_amount = 0;
        $row = Payment::findOne($pay_type);
        if ($row && $row->c_status == Payment::STATUS_YES) {
            if ($row->c_poundage_type == 1) {
                $pay_fee_amount = $this->order_data['payable_goods_amount'] * $row->c_poundage * 0.01; //按照百分比
            } else {
                $pay_fee_amount = $row->c_poundage; //按照固定金额
            }
        }
        $this->order_data['pay_fee_amount'] = $pay_fee_amount;
    }

    //获取会员组价格
    private function getGroupPrice($id) {
        if ($this->group_id) {
            $row = GroupPrice::findOne(['c_goods_id' => $id]);
            if ($row) {
                return $row->c_price;
            }
        }
        return false;
    }

}
