<?php

namespace app\models;

use Uni;
use uni\data\ActiveDataProvider;

/**
 * This is the model class for table "vk_reestr".
 *
 * @property integer $id
 * @property integer $viloyat_id
 * @property string $name_businesses
 * @property integer $tuman_id
 * @property string $adress
 * @property integer $stir
 * @property string $type_activity
 * @property string $special_code
 * @property integer $created_date
 * @property integer $updated_date
 * @property integer $user_id
  * @property integer $status
 */
class Reestr extends \uni\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_reestr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['viloyat_id', 'name_businesses', 'tuman_id', 'adress', 'stir', 'type_id', 'special_code','mfo','oked','fio','bank', 'rs'], 'required'],
            [['viloyat_id', 'tuman_id', 'stir', 'updated_date', 'created_date', 'user_id','status', 'type_id'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['rs'],'number','max'=>99999999999999999999, 'min'=>10000000000000000000],
            [['mfo','oked'],'number','max'=>99999, 'min'=>10000],
            [['stir'],'number','max'=>999999999, 'min'=>100000000],
            [['name_businesses', 'adress','fio','bank'], 'string', 'max' => 128],
            [['special_code'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Uni::t('app', 'ID'),
            'viloyat_id' => Uni::t('app', 'Region'),
            'name_businesses' => Uni::t('app', 'Name Businesses'),
            'tuman_id' => Uni::t('app', 'City'),
            'adress' => Uni::t('app', 'Address'),
            'stir' => Uni::t('app', 'INN'),
            'type_id' => Uni::t('app', 'Type Activity'),
            'special_code' => Uni::t('app', 'Special Code'),
            'created_date' => Uni::t('app', 'Created Date'),
            'status' => Uni::t('app', 'Status'),
            'updated_date' => Uni::t('app', 'Updated Date'),
            'user_id' => Uni::t('app', 'User'),
            'mfo' => Uni::t('app', 'МФО'),
            'oked' => Uni::t('app', 'Код ОКЕД'),
            'fio' => Uni::t('app', 'FIO'),
            'rs' => Uni::t('app', 'р/н'),
        ];
    }
    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->getUser()->getId();
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

    public function getType()
    {
        return $this->hasOne(TypeActivity::className(), ['id' => 'type_id']);
    }

    public function search($params) {
        if (Uni::$app->controller->access('ADMIN')) {
            $query = Reestr::find()->where(['status' => Reestr::STATUS_ACTIVE])->orWhere(['status' => Reestr::STATUS_INACTIVE])->orderBy(["id" => SORT_DESC]);
        }
        else $query = Reestr::find()->where(['status' => Reestr::STATUS_ACTIVE])->orWhere(['status' => Reestr::STATUS_INACTIVE, 'viloyat_id'=>Uni::$app->getUser()->identity->viloyat_id])->orderBy(["id" => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if(isset($params['name'])){
            $query->andFilterWhere(['like','name_businesses',$params['name']]);
        }
        if(isset($params['vk_turi'])){
            $query->andFilterWhere(['=','viloyat_id',$params['vk_turi']]);
        }
        if(isset($params['address'])){
            $query->andFilterWhere(['like','adress',$params['address']]);
        }
        return $dataProvider;

    }


}
