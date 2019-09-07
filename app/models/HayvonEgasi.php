<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "vk_hayvon_egasi".
 *
 * @property integer $id
 * @property string $name_uz
 * @property string $name_ru
 * @property integer $user_id
 * @property integer $created_date
 * @property integer $updated_date
 * @property integer $status
 */
class HayvonEgasi extends \uni\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_hayvon_egasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru'], 'required'],
            [['user_id', 'created_date', 'updated_date', 'status'], 'integer'],
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
            'name_ru' => Uni::t('app', 'Name ru'),
            'name_uz' => Uni::t('app', 'Name uz'),
            'created_date' => Uni::t('app', 'Created date'),
            'updated_date' => Uni::t('app', 'Update date'),
            'user_id' => Uni::t('app', 'User'),
            'status' => Uni::t('app', 'Status'),
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

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }
}
