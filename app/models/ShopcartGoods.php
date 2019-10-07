<?php

namespace app\models;

use Uni;
use app\models\ShopcartOrders;
use app\models\maxpirali\MenuItem;

/**
 * This is the model class for table "in_shopcart_goods".
 *
 * @property int $good_id
 * @property int $order_id
 * @property int $item_id
 * @property int $count
 * @property string $options
 * @property double $price
 * @property int $sale
 * @property int $pieces
 */
class ShopcartGoods extends \uni\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'in_shopcart_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'item_id', 'count', 'sale','pieces'], 'integer'],
            [['item_id'], 'required'],
            [['price'], 'integer'],
            // [['options'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'good_id' => 'Good ID',
            'order_id' => 'Order ID',
            'item_id' => 'Item ID',
            'count' => 'Count',
            // 'options' => 'Options',
            'price' => 'Price',
            'sale' => 'Sale',
            'pieces'=>'Pieces',
        ];
    }

    public static function saved($item_id, $quantity=1)
    {
        $item = ShopcartOrders::find()->where(['auth_user'=>Uni::$app->user->identity->id])
                ->andWhere(['access_token'=>Uni::$app->session->getId()])
                ->one();
        if (!empty($item)) {        // Agar order bor bo`lsa
                $good = self::find()->where(['order_id'=>$item->order_id])
                        ->andWhere(['item_id'=>$item_id])->one();
                if (!empty($good)) {        // Agar oldin sotib olgan bo`lsa
                    $good->count = $quantity;
                    if ($good->save()) return "success";
                    else return "error";
                }
                else {
                    $menu_item = MenuItem::find()->where(['id'=>$item_id])->asArray()->one();
                    if (!empty($menu_item)) {
                        $good = new ShopcartGoods();
                        $good->order_id = $item->order_id;
                        $good->item_id = $item_id;
                        $good->count = $quantity;
                        $good->price = $menu_item['price'];
                        $good->sale = $menu_item['sale'];
                        $good->pieces = $menu_item['pieces'];
                        if ($good->save()) return "success";
                        else return "error";                 
                    }
                    else return "error";    
                }        
        }
        else {
            $item = new ShopcartOrders();
            $item->save();

            $menu_item = MenuItem::find()->where(['id'=>$item_id])->asArray()->one();
            if (!empty($menu_item)) {
                $good = new ShopcartGoods();
                $good->order_id = $item->order_id;
                $good->item_id = $item_id;
                $good->count = 1;
                $good->price = $menu_item['price'];
                $good->sale = $menu_item['sale'];
                $good->pieces = $menu_item['pieces'];
                if ($good->save()) return "success";
                else return "error";                 
            }
            else return "error"; 
        }        
    }

    public function getOrder()
    {
        return $this->hasOne(ShopcartOrders::className(), ['order_id' => 'order_id']);
    }
    public function getItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'item_id']);
    }

    public function getCost()
    {
        return $cost = $this->count * round($this->price * (1 - $this->sale / 100));
       
    }
}
