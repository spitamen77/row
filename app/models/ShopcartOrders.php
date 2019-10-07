<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "in_shopcart_orders".
 *
 * @property int $order_id
 * @property string $mac_date
 * @property int $auth_user
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property string $remark
 * @property string $access_token
 * @property string $ip
 * @property string $payment
 * @property int $time
 * @property int $new
 * @property int $status
 * @property int $type
 */
class ShopcartOrders extends \uni\db\ActiveRecord
{
    const ADMIN_SEEN = 1; // Если пользователь Администратор(для части II)
    const ADMIN_NO_SEEN = 0; // Если пользователь Администратор(для части II)
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'in_shopcart_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['access_token', 'ip'], 'required'],
            [['auth_user', 'time', 'new', 'status', 'type'], 'integer'],
            [['name', 'phone', 'payment'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 128],
            [['comment', 'remark'], 'string', 'max' => 1024],
            [['access_token'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            // 'mac_date' => 'Mac Date',
            'auth_user' => 'Auth User',
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'comment' => 'Comment',
            'remark' => 'Remark',
            'access_token' => 'Access Token',
            'ip' => 'Ip',
            'payment' => 'Payment',
            'time' => 'Time',
            'new' => 'New',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }

    public function beforeSave($insert){
        if($insert){
            $this->auth_user = Uni::$app->user->identity->id;
            $this->access_token = Uni::$app->session->getId();
            $this->ip = Uni::$app->request->userIP;
            $this->time = time();
        }else{
            $this->auth_user = Uni::$app->user->identity->id;
            $this->time = time();
            // $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }

    public function getGoods()
    {
        return $this->hasMany(ShopcartGoods::className(), ['order_id' => 'order_id']);
    }

    public function getCost()
    {
        $total = 0;
        foreach($this->goods as $good){
            $total += $good->count * round($good->price * (1 - $good->sale / 100));
        }

        return $total;
    }

    public function getCount()
    {
        $total=0;
        foreach($this->goods as $good){
            $total += 1;
        }

        return $total;

    }

    public function afterDelete()
    {
        parent::afterDelete();

        foreach($this->getGoods()->all() as $good){
            $good->delete();
        }
    }

    public static function goods()
    {
        return self::find()->where(['access_token'=>Uni::$app->session->getId()])->one();
    }

    public function getStatus()
    {
        return [
        '0' => Uni::t('app','Tanlangan'),
        '1' => Uni::t('app','Maxsulot to`ldirilgan'),
        '2' => Uni::t('app','Maxsulot yetkazilgan'),
        // '1' => Uni::t('app','Admin'),
    ];
    }

    public static function shop()
    {
        return self::find()->where(['new'=>self::ADMIN_NO_SEEN])->andWhere(['status'=>self::ADMIN_SEEN])->count();
    }

    public static function getId(){

        $model = self::find()->where(['access_token'=>Uni::$app->session->getId()])->one();
        return $model->order_id;
    }
}
