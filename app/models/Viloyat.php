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
class Viloyat extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'uni_viloyat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_uz'], 'required'],
            [['user_id', 'status', 'updated_at'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            [['name_ru', 'name_uz'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => Uni::t('app', 'Name ru'),
            'name_uz' => Uni::t('app', 'Name uz'),
            'created_at' => Uni::t('app', 'Created time'),
            'updated_at' => Uni::t('app', 'Update time'),
            'user_id' => Uni::t('app', 'User id'),
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

    public function getTuman()
    {
        return $this->hasMany(Tuman::className(), ['viloyat_id' => 'id']);
    }

    public function getVk()
    {
        return $this->hasMany(Vkviloyat::className(), ['viloyat_id' => 'id']);
    }

    public function getViloyat()
    {
        return $this->hasOne(Vkviloyat::className(), ['viloyat_id' => 'id']);
    }

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }

    public function getSumma()
    {
        return $this->hasMany(Vkviloyat::className(), ['viloyat_id' => 'id'])->where(['status'=>Vkviloyat::STATUS_ACTIVE])->sum('vaksina_miqdor');
    }

    public function getKutish()
    {
        return $this->hasMany(Vkviloyat::className(), ['viloyat_id' => 'id'])->where(['status'=>Vkviloyat::STATUS_INACTIVE])->sum('vaksina_miqdor');
    }

    public function getQoldiq()
    {
        return $this->hasMany(Vkviloyat::className(), ['viloyat_id' => 'id'])->where(['status'=>Vkviloyat::STATUS_ACTIVE])->sum('ostatok');
    }




}
