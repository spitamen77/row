<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "uni_user_info".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $per_id
 * @property integer $start_day
 * @property integer $end_day
 * @property integer $status
 * @property integer $created_date
 * @property integer $updated_date
 */
class UserInfo extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'per_id', 'status'], 'required'],
            ['created_date', 'default', 'value' => time()],
            [['user_id', 'per_id', 'start_day', 'end_day', 'status',  'updated_date'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'per_id' => 'Per ID',
            'start_day' => Uni::t('app','Start day'),
            'end_day' => Uni::t('app','End day'),
            'status' => 'Status',
            'created_date' => Uni::t('app','Created Date'),
            'updated_date' => Uni::t('app','Updated Date'),
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
}
