<?php

namespace app\models;

use app\components\Model;
use Uni;
use app\components\http\Client;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $status
 * @property integer $confirmaction
 * @property string $message
 */
class Notification extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'message','user_id','action_page'], 'required'],
            [['user_id', 'type', 'status','role_id'], 'integer'],
            [['message','action_page'], 'string'],
        ];
    }

    public static $type_names=[
        0=>'primary',
        1=>'info',
        2=>'success',
        3=>'warning',
        4=>'danger',
    ];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Uni::t('app', 'ID'),
            'user_id' => Uni::t('app', 'User ID'),
            'type' => Uni::t('app', 'Type'),
            'status' => Uni::t('app', 'Status'),
            'confirmaction' => Uni::t('app', 'Confirmaction'),
            'message' => Uni::t('app', 'Message'),
        ];
    }
    public function beforeSave($insert){
        if($insert){
            if (!empty(Uni::$app->getUser()->getId())) $this->owner_id = Uni::$app->getUser()->getId();
            else $this->owner_id = 0;
            $this->created_date = time();
            $this->status = 1;
        }
        else{
            $this->created_date = strtotime($this->created_date);
        }
        return parent::beforeSave($insert);
    }
    public function afterFind(){
        if(is_integer($this->created_date)){
            $this->created_date = date('Y-m-d',$this->created_date);
        }
    }
    public function getDropDownProp($prop)
    {
        return false;
    }
    public static function getNotViewed($user=false){
        $notifications=Notification::find();
        if($user!=false)$notifications->where(["user_id"=>$user,'status'=>0]);
        return $notifications->all();

    }
    public static function getAll($user=false){
        $notifications=Notification::find();
        if($user!=false)$notifications->where(["user_id"=>$user]);
        return $notifications->all();
    }
    public static function getNotConfirmed($user=false){
        $notifications=Notification::find();
        if($user!=false)$notifications->where(["user_id"=>$user,'status'=>1]);
        return $notifications->all();
    }
    public function getTypename(){
        $name=["danger","info","success","warning"];
        return $name[$this->type];
    }
    public function getRole(){
        return $this->hasOne(Groups::className(),['id'=>'role_id']);
    }
    public static function saveInstantce($users,$data){
        foreach ($users as $user){
            $n=new Notification();
            $n->user_id=$user['id'];
            if (isset($user['phone'])) self::Send(Uni::t('app', 'You have a new message in the VET system'), $user['phone']);
            $n->action_page = $data['action_page'];
            $n->message = $data['message'];
            $n->type = 1;
            $n->role_id = 0;
            $n->save();
        }
    }

    public static function Send($message, $phone)
    {
        $sms = new Client(['baseUrl' => 'http://notify.eskiz.uz/api/message/sms/send']);
        $login = new Client(['baseUrl' => 'http://notify.eskiz.uz/api/auth/login']);
        $response = $login->createRequest()
            ->setMethod('POST')
            ->addHeaders(['content-type'=>'application/json'])
            ->setData([
                'email' => 'rnn0891@gmail.com',
                'password' => 'NEqhOrcb4yDSpPQsK0nhfQ1wetSyk1FYIUezAXVm'
            ])
            ->send();
        $code = $sms->createRequest()
            ->setMethod('POST')
            ->setHeaders(['Authorization' => 'Bearer ' . $response->data["data"]["token"]])
            ->addHeaders(['content-type'=>'application/json'])
            ->setData([
                'message' => $message,
                'mobile_phone' => $phone
            ])
            ->send();
    }

    public static function Sms()
    {
        $client = new Client(['baseUrl' => 'http://notify.eskiz.uz/api/auth/login']);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->addHeaders(['content-type'=>'application/json'])
            ->setData([
                'email' => 'rnn0891@gmail.com',
                'password' => 'NEqhOrcb4yDSpPQsK0nhfQ1wetSyk1FYIUezAXVm'
            ])
            ->send();
    }
}
