<?php

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "vk_contravention".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $created_date
 * @property integer $date
 * @property string $comment
 * @property integer $user_id
 * @property string $file
 */
class Contravention extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_contravention';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'date', 'comment'], 'required'],
            [['company_id', 'created_date',  'user_id'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['comment'], 'string'],
            [['file'], 'file'],
            [['file'],'safe']
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
            'created_date' => Uni::t('app', 'Created Date'),
            'date' => Uni::t('app', 'Date'),
            'comment' => Uni::t('app', 'Comment'),
            'user_id' => Uni::t('app', 'User ID'),
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

    public function getCompany()
    {
        return $this->hasOne(Reestr::className(), ['id'=>'company_id']);
    }
}
