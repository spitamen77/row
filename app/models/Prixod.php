<?php

namespace app\models;

use Uni;
use uni\data\ActiveDataProvider;

/**
 * This is the model class for table "vk_proxod".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_uz
 * @property integer $count
 * @property integer $created_date
 * @property integer $number
 */
class Prixod extends \uni\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    const STATUS_DENIED = 2;
    const STATUS_CLOSED = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_proxod';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_uz', 'count','number', 'unit_id', 'vaksina_id', 'prixod_date'], 'required'],
            [['count', 'created_date','ostatok', 'updated_date', 'status', 'user_id'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['name_ru', 'name_uz','number'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => Uni::t('app', 'Count'),
            'number' => Uni::t('app', 'Number'),
            'name_ru' => Uni::t('app', 'Name ru'),
            'name_uz' => Uni::t('app', 'Name uz'),
            'created_date' => Uni::t('app', 'Created date'),
            'updated_date' => Uni::t('app', 'Update date'),
            'prixod_date' => Uni::t('app', 'Arrival date'),
            'user_id' => Uni::t('app', 'User'),
            'unit_id' => Uni::t('app', 'Unit'),
            'vaksina_id' => Uni::t('app', 'Vaccine'),
            'status' => Uni::t('app', 'Status'),
            'ostatok' => Uni::t('app', 'The remainder'),
        ];
    }

    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->getUser()->getId();
            $this->ostatok = $this->count;
        }else{
            $this->user_id = Uni::$app->getUser()->getId();
            $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }

    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    public function getVaksina()
    {
        return $this->hasOne(Vaksina::className(), ['id' => 'vaksina_id']);
    }

    public static function getCount($vil_id=false, $tum_id = false)
    {
        $user=Uni::$app->getUser()->getIdentity();
        if (Uni::$app->controller->access('ADMIN_TUM')){
            $vil_id = $user->viloyat_id; $tum_id = $user->tuman_id;
            return VkTuman::find()->where(['status'=>VkTuman::STATUS_ACTIVE, 'viloyat_id'=>$vil_id, 'tuman_id'=>$tum_id])->count();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $vil_id = $user->viloyat_id;
            return VkViloyat::find()->where(['status'=>VkViloyat::STATUS_ACTIVE, 'viloyat_id'=>$vil_id])->count();
        }
        if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')){
            return self::find()->where(['status'=>1])->count();
        }
        return 0;
    }

    public static function getRasxod($vil_id=false, $tum_id = false)
    {
        $user=Uni::$app->getUser()->getIdentity();
        if (Uni::$app->controller->access('ADMIN_TUM')){
            $vil_id = $user->viloyat_id; $tum_id = $user->tuman_id;
            return VkTuman::find()->where(['status'=>VkTuman::STATUS_ACTIVE, 'viloyat_id'=>$vil_id, 'tuman_id'=>$tum_id])->count();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $vil_id = $user->viloyat_id;
            return VkViloyat::find()->where(['status'=>VkViloyat::STATUS_ACTIVE, 'viloyat_id'=>$vil_id])->count();
        }
        if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')){
            return self::find()->where(['status'=>Prixod::STATUS_ACTIVE])->count();
        }
        return 0;
    }

    public static function getKutish($vil_id=false, $tum_id = false)
    {
        $user=Uni::$app->getUser()->getIdentity();
        if (Uni::$app->controller->access('ADMIN_TUM')){
            $vil_id = $user->viloyat_id; $tum_id = $user->tuman_id;
            return VkTuman::find()->where(['status'=>VkTuman::STATUS_INACTIVE, 'viloyat_id'=>$vil_id, 'tuman_id'=>$tum_id])->count();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $vil_id = $user->viloyat_id;
            return VkViloyat::find()->where(['status'=>VkViloyat::STATUS_INACTIVE, 'viloyat_id'=>$vil_id])->count();
        }
        if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')){
            return self::find()->where(['status'=>Prixod::STATUS_INACTIVE])->count();
        }
        return 0;
    }

    public static function getOtkaz($vil_id=false, $tum_id = false)
    {
        $user=Uni::$app->getUser()->getIdentity();
        if (Uni::$app->controller->access('ADMIN_TUM')){
            $vil_id = $user->viloyat_id; $tum_id = $user->tuman_id;
            return VkTuman::find()->where(['status'=>VkTuman::STATUS_DENIED, 'viloyat_id'=>$vil_id, 'tuman_id'=>$tum_id])->count();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $vil_id = $user->viloyat_id;
            return VkViloyat::find()->where(['status'=>VkViloyat::STATUS_DENIED, 'viloyat_id'=>$vil_id])->count();
        }
        if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')){
            return self::find()->where(['status'=>Prixod::STATUS_DENIED])->count();
        }
        return 0;
    }

    public static function getNew($vil_id=false, $tum_id = false)
    {
        $user=Uni::$app->getUser()->getIdentity();
        if (Uni::$app->controller->access('ADMIN_TUM')){
            $vil_id = $user->personal->viloyat_id; $tum_id = $user->personal->tuman_id;
            return VkTuman::find()->where(['status'=>VkTuman::STATUS_INACTIVE, 'viloyat_id'=>$vil_id, 'tuman_id'=>$tum_id])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $vil_id = $user->personal->viloyat_id;
            return VkViloyat::find()->where(['status'=>VkViloyat::STATUS_INACTIVE, 'viloyat_id'=>$vil_id])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        }
        return self::find()->where(['status'=>Prixod::STATUS_INACTIVE])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
    }

    public static function getAccepted($vil_id=false, $tum_id = false)
    {
        $user=Uni::$app->getUser()->getIdentity();
        if (Uni::$app->controller->access('ADMIN_TUM')){
            $vil_id = $user->viloyat_id; $tum_id = $user->tuman_id;
            return VkTuman::find()->where(['status'=>VkTuman::STATUS_ACTIVE, 'viloyat_id'=>$vil_id, 'tuman_id'=>$tum_id])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $vil_id = $user->viloyat_id;
            return VkViloyat::find()->where(['status'=>VkViloyat::STATUS_ACTIVE, 'viloyat_id'=>$vil_id])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        }
        return self::find()->where(['status'=>Prixod::STATUS_ACTIVE])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
    }

    public static function getDenied($vil_id=false, $tum_id = false)
    {
        $user=Uni::$app->getUser()->getIdentity();
        if (Uni::$app->controller->access('ADMIN_TUM')){
            $vil_id = $user->viloyat_id; $tum_id = $user->tuman_id;
            return VkTuman::find()->where(['status'=>VkTuman::STATUS_DENIED, 'viloyat_id'=>$vil_id, 'tuman_id'=>$tum_id])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $vil_id = $user->viloyat_id;
            return VkViloyat::find()->where(['status'=>VkViloyat::STATUS_DENIED, 'viloyat_id'=>$vil_id])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        }
        return self::find()->where(['status'=>Prixod::STATUS_DENIED])->orderBy(['id'=>SORT_DESC])->limit(10)->all();
    }

    public function search($params) {
        $query = Prixod::find()->where(['status'=>Prixod::STATUS_ACTIVE])->orWhere(['status'=>Prixod::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        if(isset($params['name'])){
            $query->andFilterWhere(['like','name_uz',$params['name']])
                ->orFilterWhere(['like','name_ru',$params['name']]);
        }
        if(isset($params['vk_turi'])){
            $query->andFilterWhere(['=','vaksina_id',$params['vk_turi']]);
        }
        if(isset($params['unit_id'])){
            $query->andFilterWhere(['=','unit_id',$params['unit_id']]);
        }
        return $dataProvider;

    }

//    public function search($params,$error=false){
//        $user = Uni::$app->getUser()->identity;
//
//        // if(Uni::$app->controller->access('ADMIN_VIL')) $query = Prixod::find()->where(['']);
//        // if(Uni::$app->controller->access('ADMIN')) $query = Prixod::find();
//        // if(Uni::$app->controller->access('HEAD')) $query = Prixod::find();
//
//        $query = Prixod::find();
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//        $dataProvider->pagination->pageSize=15;
//        if(isset($params['vaksina_id']))$query->andFilterWhere(['=','vaksina_id',$params['vaksina_id']]);
//        if(Uni::$app->controller->access('ADMIN_TUM')){
//            $user=Uni::$app->getUser()->getIdentity();
//            $query->joinWith('tuman')->andFilterWhere(['=','`vk_tuman`.`tuman_id`',$user->tuman_id]);
//        }
//        if(isset($params['sort'])){
//            if(substr($params["sort"],0,1)=="-"){
//                if(isset($this->{substr($params["sort"],1)})) $query->addOrderBy([substr($params["sort"],1)=>SORT_ASC]);
//            }
//            else { if(isset($this->$params["sort"]))$query->addOrderBy([$params["sort"]=>SORT_DESC]);}
//        }else{
//            $query->addOrderBy(["id"=>SORT_DESC,]);
//        }
//        return $dataProvider;
//    }
}
