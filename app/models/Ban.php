<?php

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "vk_ban".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $user_id
 * @property integer $created_date
 * @property integer $status
 * @property string $comment
 */
class Ban extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_ban';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'start_date', 'end_date',  'comment'], 'required'],
            [['company_id', 'user_id', 'created_date', 'status'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['comment'], 'string'],
            [['file'], 'string', 'max' => 2048]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Uni::t('app', 'ID'),
            'company_id' => Uni::t('app', 'Company ID'),
            'start_date' => Uni::t('app', 'Start Date'),
            'end_date' => Uni::t('app', 'End Date'),
            'user_id' => Uni::t('app', 'User ID'),
            'created_date' => Uni::t('app', 'Created Date'),
            'status' => Uni::t('app', 'Status'),
            'comment' => Uni::t('app', 'Comment'),
            'file' => Uni::t('app', 'File'),
        ];
    }
    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->getUser()->getId();
        }else{
            $this->user_id = Uni::$app->getUser()->getId();
//            $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }

}
