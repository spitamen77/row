<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "uni_uchastka".
 *
 * @property integer $id
 * @property integer $viloyat_id
 * @property integer $tuman_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $update_at
 * @property string $name_uz
 * @property string $name_ru
 * @property integer $user_id
 */
class Uchastka extends \uni\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_uchastka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['viloyat_id', 'tuman_id', 'name_uz', 'name_ru'], 'required'],
            [['viloyat_id', 'tuman_id', 'status', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['name_uz', 'name_ru'], 'string', 'max' => 255],
             ['created_at', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'viloyat_id' => Uni::t('app', 'Region'),
            'tuman_id' => Uni::t('app', 'City'),
            'status' => 'Status',
            'user_id' => Uni::t('app', 'User'),
            'name_ru' => Uni::t('app', 'Name ru'),
            'name_uz' => Uni::t('app', 'Name uz'),
            'created_at' => Uni::t('app', 'Created time'),
            'updated_at' => Uni::t('app', 'Update time'),
        ];
    }

    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->getUser()->getId();
        }else{
            $this->user_id = Uni::$app->getUser()->getId();
            $this->updated_at = time();
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

    // public function getVkuchas()
    // {
    //     return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id']);
    // }

    // public function getSumma()
    // {
    //     return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id'])->where(['status'=>VkUchastka::STATUS_ACTIVE])->sum('vaksina_miqdor');
    // }

    // public function getKutish()
    // {
    //     return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id'])->where(['status'=>VkUchastka::STATUS_INACTIVE])->sum('vaksina_miqdor');
    // }

    // public function getQoldiq()
    // {
    //     return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id'])->where(['status'=>VkUchastka::STATUS_ACTIVE])->sum('ostatok');
    // }

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }
}
