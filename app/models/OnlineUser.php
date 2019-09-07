<?php

namespace app\models;

use app\components\logger\GetIP;
use app\components\Model;
use Uni;

/**
 * This is the model class for table "online_user".
 *
 * @property integer $id
 * @property integer $date
 * @property integer $user_id
 * @property string $ip
 * @property string $last_page
 */
class OnlineUser extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_online_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'user_id', 'ip', 'last_page'], 'required'],
            [['date', 'user_id'], 'integer'],
            [['ip'], 'string', 'max' => 100],
            [['last_page'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'user_id' => 'User ID',
            'ip' => 'Ip',
            'last_page' => 'Last Page',
        ];
    }
    public static function UsersForChat(){
        $users=OnlineUser::find()->where('user_id!=:user and user_id!=:admin', array(':user' => -1,'admin'=>Uni::$app->user->identity->id))->all();
        if($users){
            $res=[];
            foreach($users as $u){
               $info=$u->users;
                    $res[]=$info->info;
            }
            return $res;
        }

    }
    public static function deleteOffline()
    {
        $time = time() - 60;
        self::deleteAll('date < :date', [':date' => $time]);
    }
    public static function saveOnline()
    {
        $user = Uni::$app->getUser();
        if (!$user->isGuest) {
            $u = self::find()->where(['user_id' => Uni::$app->user->id])->one();
            if ($u) {
                $u->last_page=Uni::$app->request->absoluteUrl;
                $u->date = time();
            } else {
                $u = new OnlineUser();
                $u->date = time();
                $u->last_page=Uni::$app->request->absoluteUrl;
                $u->user_id = Uni::$app->user->id;
                $u->ip = GetIP::getIP();
            }
            $u->save();
        } else {
            $ip = GetIP::getIP();
            $u = self::find()->where(['ip' => $ip])->one();

            if ($u) {
                $u->date = time();
            } else {
                $u = new OnlineUser();
                $u->date = time();
                $u->user_id = -1;
                $u->ip = GetIP::getIP();
            }
            $u->save();
        }
    }
    public function afterSave($insert,$changedAttributes){
        return true;
    }
    public function getUsers(){
        return $this->hasOne(UserModel::className(),["id"=>"user_id"]);
    }

    public function getDropDownProp($prop)
    {
        // TODO: Implement getDropDownProp() method.
    }
}
