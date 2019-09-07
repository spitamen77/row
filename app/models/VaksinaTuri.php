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
 * This is the model class for table "vk_vaksina_turi".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_uz
 * @property integer $status
 * @property integer $user_id
 * @property integer $created_date
 * @property integer $updated_date
 *
 */
class VaksinaTuri extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;

    public static function tableName()
    {
        return 'vk_vaksina_turi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru','name_uz'], 'required'],
            [['user_id', 'status', 'updated_date', 'created_date'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['name_ru','name_uz'], 'string', 'max' => 1024]
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
            'created_date' => Uni::t('app', 'Created time'),
            'updated_date' => Uni::t('app', 'Update time'),
            'user_id' => Uni::t('app', 'User'),
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

    public function getVaksina()
    {
        return $this->hasMany(Vaksina::className(), ['vk_turi' => 'id']);
    }

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }
}
