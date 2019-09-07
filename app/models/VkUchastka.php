<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "vk_uchastka".
 *
 * @property integer $id
 * @property integer $viloyat_id
 * @property integer $tuman_id
 * @property integer $uchastka_id
 * @property integer $vaksina_miqdor
 * @property integer $vaksina_id
 * @property integer $vaksina_date
 * @property string $number
 * @property integer $ostatok
 * @property integer $tum_prixod
 * @property integer $prixod_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class VkUchastka extends \uni\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DENIED = 2;
    const STATUS_CLOSED = 3;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_uchastka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['viloyat_id', 'tuman_id',  'vaksina_miqdor',  'vaksina_date', 'nomer', 'tum_prixod'], 'required'],
            [['viloyat_id', 'tuman_id', 'uchastka_id', 'vaksina_miqdor', 'vaksina_id', 'vaksina_date', 'ostatok', 'tum_prixod', 'prixod_id', 'user_id', 'updated_at', 'status'], 'integer'],
            [['nomer'], 'string', 'max' => 128],
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
            'uchastka_id' => 'Uchastka ID',
            'tum_prixod' => 'Tum Prixod',
            'prixod_id' => 'Prixod ID',
            'status' => 'Status',
            'vaksina_miqdor' => Uni::t('app', 'The amount of vaccine'),
            'vaksina_id' => Uni::t('app', 'Vaccine'),
            'vaksina_date' => Uni::t('app', 'Date of issue'),
            'tuman_id' => Uni::t('app','City'),
            'viloyat_id' => Uni::t('app','Region'),
            'created_at' => Uni::t('app', 'Created time'),
            'updated_at' => Uni::t('app', 'Update time'),
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
        return $this->hasOne(Viloyat::className(), ['id' => 'tuman_id']);
    }

    public function getVaksina()
    {
        return $this->hasOne(Vaksina::className(), ['id' => 'vaksina_id']);
    }

     public function getUser()
     {
         return$this->hasOne(UserModel::className(), ['id'=>'uchastka_id']);
     }
    public function getHudud()
    {
        return$this->hasOne(Uchastka::className(), ['id'=>'uchastka_id']);
    }

    public function getPrixod()
    {
        return $this->hasOne(Prixod::className(), ['id' => 'prixod_id']);
    }

    public function getTumprixod()
    {
        return $this->hasOne(VkTuman::className(), ['id' => 'tum_prixod']);
    }



}
