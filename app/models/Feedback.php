<?php

namespace app\models;

use app\components\Model;
use Uni;
use uni\helpers\ArrayHelper;

class Feedback extends  Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kasb_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email','subject', 'text'], 'required'],
            ['email', 'email'],
            [['date', 'status'], 'integer'],
            [['subject'], 'string', 'max' => 1024],
            [['email','name'], 'string', 'max' => 150],
            [['text'], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Uni::t('app', 'ID'),
            'name' => Uni::t('app', 'F.I.SH.'),
            'email' => Uni::t('app', 'Email'),
            'subject' => Uni::t('app', 'Sarlavha'),
            'text' => Uni::t('app', 'Matn'),
            'date' => Uni::t('app', 'Sana'),
            'status' => Uni::t('app', 'Status')
        ];
    }
    public function beforeSave($insert)
    {
        $this->date = time();
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->date = date('d-m-Y',$this->date);
        return parent::afterFind();
    }
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['user_id' => 'id']);
    }

    public function getSpeciality()
    {
        return $this->hasOne(UserModel::className(), ['speciality_id' => 'id']);


    }
}