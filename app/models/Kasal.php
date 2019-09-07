<?php

namespace app\models;

use Uni;
use uni\data\ActiveDataProvider;
/**
 * This is the model class for table "vk_kasal".
 *
 * @property integer $id
 * @property integer $kasal_id
 * @property integer $created_time
 * @property integer $updated_time
 * @property string $name_ru
 * @property string $name_uz
 * @property integer $status
 * @property integer $user_id
 */
class Kasal extends \uni\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_kasal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kasal_id','name_uz'], 'required'],
            [['kasal_id', 'created_date', 'updated_date', 'status', 'user_id'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['name_ru', 'name_uz'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kasal_id' => Uni::t('app', 'Disease'),
            'name_ru' => Uni::t('app', 'Name ru'),
            'name_uz' => Uni::t('app', 'Name uz'),
            'created_date' => Uni::t('app', 'Created date'),
            'updated_date' => Uni::t('app', 'Update date'),
            'user_id' => Uni::t('app', 'User'),
            'status' => Uni::t('app', 'Status'),
        ];
    }

    public function getTuri()
    {
        return $this->hasOne(KasalTuri::className(), ['id' => 'kasal_id']);
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
    public function search($params, $error = false)
    {
        $query = Kasal::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize = 20;
        if (isset($params['Kasal']['type'])) $query->andFilterWhere(['=', 'type', $params['Kasal']['type']]);
        if (isset($params['Kasal']['title'])) $query->andFilterWhere(['like', 'title', $params['Kasal']['title']]);
        if (isset($params['Kasal']['number'])) $query->andFilterWhere(['=', 'number', $params['Kasal']['number']]);
        if (isset($params['Kasal']['head'])) $query->andFilterWhere(['=', 'head', $params['Kasal']['head']]);
        if (isset($params['Kasal']['ageed'])) $query->andFilterWhere(['like', 'ageed', "#".$params['Kasal']['ageed'].";"]);
        if (isset($params['Kasal']['deadline'])) $query->andFilterWhere(['=', 'deadline', strtotime($params['Kasal']['deadline'])]);
        if (isset($params['Kasal']['status'])) $query->andFilterWhere(['=', 'status', $params['Kasal']['status']]);
        if (isset($params['Kasal']['user_id'])) $query->andFilterWhere(['=', 'user_id', $params['Kasal']['user_id']]);
        if (isset($params['Kasal']['added_uid'])) $query->andFilterWhere(['=', 'added_uid', $this->getStatusNum($params['Kasal']['added_uid'])]);

        return $dataProvider;
    }
}
