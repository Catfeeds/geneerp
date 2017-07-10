<?php

namespace common\extensions;

use Yii;

class GoodsCart {

    protected static $ins; //实例变量
    public $item = []; //放商品容器

    const cart_name = 'goodscart'; //购物车名称

    //禁止外部调用

    final protected function __construct() {
        
    }

    //禁止克隆
    final protected function __clone() {
        
    }

    //类内部实例化
    protected static function getIns() {
        if (!(self::$ins instanceof self)) {
            self::$ins = new self();
        }
        return self::$ins;
    }

    //为了能使商品跨页面保存，把对象放入session里
    public static function getCart() {
        if (!isset(Yii::$app->session[self::cart_name]) || !(Yii::$app->session[self::cart_name] instanceof self)) {
            Yii::$app->session[self::cart_name] = self::getIns();
        }
        return Yii::$app->session[self::cart_name];
    }

    public function setCart(array $cart) {
        $this->item = $cart;
    }

    //入列时的检验，是否在$item里存在
    public function inItem($goods_id) {
        if ($this->getTypes() == 0) {
            return false;
        }
        //这里检验商品是否相同是通过goods_id来检测，并未通过商品名称title来检测，具体情况可做修改
        if (!(array_key_exists($goods_id, $this->item))) {
            return false;
        } else {
            return $this->item[$goods_id]['count']; //返回此商品个数
        }
    }

    /**
     * 添加一个商品
     * @param type $goods_id
     * @param type $title
     * @param type $price
     * @param type $picture
     * @param type $count
     * @param type $append 是否累计商品数量
     * @return type
     */
    public function addItem($goods_id, $title, $price, $picture = '', $count = 1, $append = true) {
        if ($append && $this->inItem($goods_id) != false) {
            $this->item[$goods_id]['count']+= $count;
            return;
        }
        $this->item[$goods_id] = array(); //一个商品为一个数组
        $this->item[$goods_id]['title'] = $title; //商品名字
        $this->item[$goods_id]['price'] = floatval($price); //商品单价
        $this->item[$goods_id]['picture'] = $picture; //商品名字
        $this->item[$goods_id]['count'] = $count; //这一个商品的购买数量
    }

    //减少一个商品
    public function reduceItem($goods_id, $count) {
        if ($this->inItem($goods_id) == false) {
            return;
        }
        if ($count > $this->getNum($goods_id)) {
            unset($this->item[$goods_id]);
        } else {
            $this->item[$goods_id]['count']-= $count;
        }
    }

    //去掉一个商品
    public function deleteItem($goods_id) {
        if ($this->inItem($goods_id)) {
            unset($this->item[$goods_id]);
        }
    }

    //返回购买商品列表
    public function itemList() {
        return $this->item;
    }

    //一共有多少种商品
    public function getTypes() {
        return count($this->item);
    }

    //获得一种商品的总个数
    public function getTypeCount($goods_id) {
        return $this->item[$goods_id]['count'];
    }

    // 查询购物车中有多少个商品
    public function getAllCount() {
        $num = 0;
        if ($this->getTypes() == 0) {
            return 0;
        }
        foreach ($this->item as $v) {
            $num+= $v['count'];
        }
        return $num;
    }

    //计算总价格
    public function getPrice() {
        $price = 0;
        if ($this->getTypes() == 0) {
            return 0;
        }
        foreach ($this->item as $v) {
            $price+= $v['count'] * $v['price'];
        }
        return $price;
    }

    //清空购物车
    public function clearCart() {
        $this->item = [];
    }

}
