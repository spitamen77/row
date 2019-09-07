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
 * This is the model class for table "uni_viloyat".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_uz
 * @property integer $status
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property GroupsModules[] $sedGroupsModules
 * @property GroupsUsers[] $sedGroupsUsers
 */
class Vktuman extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;    
    const STATUS_DENIED = 2;
    const STATUS_CLOSED = 3;
    const STATUS_DELETED = 9;

    public static function tableName()
    {
        return 'vk_tuman';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vaksina_miqdor', 'vaksina_id','tuman_id', 'vaksina_date', 'nomer', 'vil_prixod'], 'required'],
            [['user_id', 'viloyat_id','status', 'updated_date', 'prixod_id','ostatok'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['nomer'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vaksina_miqdor' => Uni::t('app', 'The amount of vaccine'),
            'vaksina_id' => Uni::t('app', 'Vaccine'),
            'vaksina_date' => Uni::t('app', 'Date of issue'),
            'tuman_id' => Uni::t('app','City'),
            'viloyat_id' => Uni::t('app','Region'),
            'created_date' => Uni::t('app', 'Created time'),
            'updated_date' => Uni::t('app', 'Update time'),
            'user_id' => Uni::t('app', 'User'),
            'ostatok' => Uni::t('app', 'The remainder'),
            'nomer' => Uni::t('app', 'Number'),
            'vil_prixod' => Uni::t('app', 'Arrival number'),
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

    public function getViloyat()
    {
        return $this->hasOne(Viloyat::className(), ['id' => 'viloyat_id']);
    }

    public function getTuman()
    {
        return $this->hasOne(Tuman::className(), ['id' => 'tuman_id']);
    }

    public function getVaksina()
    {
        return $this->hasOne(Vaksina::className(), ['id' => 'vaksina_id']);
    }

    public function getPrixod()
    {
        return $this->hasOne(Prixod::className(), ['id' => 'prixod_id']);
    }

    public function getVilprixod()
    {
        return $this->hasOne(VkViloyat::className(), ['id' => 'vil_prixod']);
    }

    public function checkValid()
    {
        $sm = VkViloyat::find()->where(['viloyat_id'=>$this->viloyat_id])->one();
        $r = Uni::$app->db->createCommand("SELECT sum(vaksina_miqdor) as miqdor FROM vk_tuman as b where viloyat_id = ".$this->viloyat_id);
        $sum = $r->queryAll();
        $sum = $sum[0]['miqdor'];
        if($sm-$sum+$this->vaksina_miqdor < 0 ) return false;
        return true;
        // echo $sm-$sum+$this->vaksina_miqdor;
        // echo 'salom';
    }

    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }

    public function search($params) {
        $userId = Uni::$app->getUser()->identity->personal->viloyat_id;
//        $current = Lang::getCurrent();
        $query = VkTuman::find()->where("`vk_tuman`.`status`=1 and `vk_tuman`.`viloyat_id`=$userId")->orderBy(["id"=>SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        if(isset($params['region'])){
            $query->andFilterWhere(['=','tuman_id',$params['region']]);
        }
        if(isset($params['vak_name'])){
            $query->andFilterWhere(['=','vaksina_id',$params['vak_name']])
                ->andFilterWhere(['=','viloyat_id',$userId]);
        }
        if(isset($params['pri_name'])){
            $query->andFilterWhere(['=','prixod_id',$params['pri_name']])
                ->andFilterWhere(['=','viloyat_id',$userId]);
        }
        return $dataProvider;

    }
}
