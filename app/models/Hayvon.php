<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "vk_hayvon".
 *
 * @property integer $id
 * @property integer $hayvon_turi_id
 * @property string $nomi
 * @property integer $user_id
 * @property integer $created_date
 * @property integer $updated_date
 * @property integer $status
 */
class Hayvon extends \uni\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_hayvon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hayvon_turi_id', 'name_ru', 'name_uz', 'rang_id'], 'required'],
            [['hayvon_turi_id', 'user_id', 'created_date', 'updated_date', 'status'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['name_uz', 'name_ru'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hayvon_turi_id' => Uni::t('app', 'Animal type'),
            'name_ru' => Uni::t('app', 'Name ru'),
            'name_uz' => Uni::t('app', 'Name uz'),
            'created_date' => Uni::t('app', 'Created date'),
            'updated_date' => Uni::t('app', 'Update date'),
            'user_id' => Uni::t('app', 'User'),
            'rang_id' => Uni::t('app', 'Color'),
            'status' => Uni::t('app', 'Status'),
        ];
    }

    public function getTuri()
    {
        return $this->hasOne(HayvonTuri::className(), ['id' => 'hayvon_turi_id']);
    }

    public function getColor()
    {
        return $this->hasOne(HayvonRangi::className(), ['id' => 'rang_id']);
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

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }

}
