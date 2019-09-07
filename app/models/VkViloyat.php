<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 11:00
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\models;

use app\components\Model;
use Uni;
use uni\data\ActiveDataProvider;

/**
 * This is the model class for table "vk_viloyat".
 *
 * @property integer $id
 * @property integer $proxod_date
 * @property integer $proxod_id
 * @property integer $status
 * @property integer $user_id
 * @property integer $created_date
 * @property integer $updated_date
 *
 * @property GroupsModules[] $sedGroupsModules
 * @property GroupsUsers[] $sedGroupsUsers
 */
class VkViloyat extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DENIED = 2;
    const STATUS_CLOSED = 3;
    const STATUS_DELETED = 9;

    public static function tableName()
    {
        return 'vk_viloyat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vaksina_miqdor', 'vaksina_id','viloyat_id', 'proxod_id', 'proxod_date', 'nomer'], 'required'],
            [['user_id', 'status', 'updated_date','viloyat_id', 'kamomat', 'proxod_id', 'proxod_date', 'ostatok'], 'integer'],
            [['nomer'], 'string', 'max' => 128],
            ['created_date', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vaksina_miqdor' => Uni::t('app', 'Vaksina miqdor'),
            'vaksina_id' => Uni::t('app', 'Vaksina'),
            'proxod_id' => Uni::t('app', 'Arrival  number'),
            'proxod_date' => Uni::t('app', 'Arrival date'),
            'created_date' => Uni::t('app', 'Created time'),
            'updated_date' => Uni::t('app', 'Update time'),
            'user_id' => Uni::t('app', 'User'),
            'ostatok' => Uni::t('app', 'The remainder'),
            'nomer' => Uni::t('app', 'Number'),
        ];
    }

    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->getUser()->getId();
            $this->ostatok = $this->vaksina_miqdor;
        }else{
            $this->user_id = Uni::$app->getUser()->getId();
            $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert,$attr){
        if($insert){
            $users=UserModel::find()->where('viloyat_id='.$this->viloyat_id." and uni_groups_users.group_id=24")
                ->joinWith('groupsUsers')->asArray()->all();
            $data['message']='New vaccine';
            $data['action_page']='settings/vkviloyat/prixod/view'.$this->id;
            Notification::saveInstantce($users,$data);

        }
        return parent::afterSave($insert,$attr);
    }

    public function getViloyat()
    {
        return $this->hasOne(Viloyat::className(), ['id' => 'viloyat_id']);
    }

    public function getVaksina()
    {
        return $this->hasOne(Vaksina::className(), ['id' => 'vaksina_id']);
    }

    public function getPrixod()
    {
        return $this->hasOne(Prixod::className(), ['id' => 'proxod_id']);
    }

//    public function getCount()
//    {
//        $sum = 0;
//        foreach (self::find()->where(['viloyat_id'=>$id])->all() as $key => $value) {
//            $sum+=$value->vaksina_miqdor;
//        }
//        return 15;
//    }
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
//    public function afterSave($insert, $changedAttributes)
//    {
//        if($insert){
//            $n = new Notification();
//            $n->type=1;
//            $n->status=0;
//            $n->owner_id = Uni::$app->getUser()->identity->id;
//            $n->user_id = $this->viloyat_id;
//            //$class=self::className();
//            $n->message="<b>".Uni::t('app','New incoming prixod')."</b> ";
//            //$n->confirmaction="?src=fromnotification";
//            if($n->save()){
//                echo "save bomadi";
//            }else{
//                var_dump($n);
//            }
//        }
//
//        parent::afterSave($insert, $changedAttributes);
//    }
    public function search($params,$error=false){
        $user = Uni::$app->getUser()->identity;
        
        if(Uni::$app->controller->access('ADMIN_VIL')) $query = self::find()->where(['viloyat_id'=>$user->viloyat_id]);
        if(Uni::$app->controller->access('ADMIN')) $query = self::find();
        if(Uni::$app->controller->access('HEAD')) $query = self::find();
        
//        var_dump($params); exit;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize=15;
        if(isset($params['region']))$query->andFilterWhere(['=','viloyat_id',$params['region']]);
        if(Uni::$app->controller->access('TUM')){
            $user=Uni::$app->getUser()->getIdentity();
            $query->joinWith('tuman')->andFilterWhere(['=','`vk_tuman`.`tuman_id`',$user->tuman_id]);
        }
        if(isset($params['pri_name'])){
            $query->andFilterWhere(['=','proxod_id',$params['pri_name']]);
        }
        if(isset($params['vac_name'])){
            $query->andFilterWhere(['=','vaksina_id',$params['vac_name']]);
        }
        if(isset($params['sort'])){
            if(substr($params["sort"],0,1)=="-"){
                if(isset($this->{substr($params["sort"],1)})) $query->addOrderBy([substr($params["sort"],1)=>SORT_ASC]);
            }
            else { if(isset($this->$params["sort"]))$query->addOrderBy([$params["sort"]=>SORT_DESC]);}
        }else{
            $query->addOrderBy(["id"=>SORT_DESC,]);
        }
        $query->andWhere(['<>','status',9]);
        return $dataProvider;
    }
}
