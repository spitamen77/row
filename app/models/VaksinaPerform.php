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
use uni\data\ActiveDataProvider;

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
class VaksinaPerform extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    
    public static function tableName()
    {
        return 'vk_vaksina_perform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vaksina_miqdor', 'vaksina_id', 'hayvon_turi', 'hayvon_egasi', 'hayvon_egasi_turi', 'location_longitude', 'location_latitude'], 'required'],
            [['uchastka_id', 'status', 'created_at', 'vaksina_id', 'prixod_uchastka_id', 'hayvon_yoshi'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            [['hayvon_egasi'], 'string', 'max' => 512],
            [['manzil'], 'string', 'max' => 1024],
            [['location_longitude', 'location_latitude'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vaksina_miqdor' => Uni::t('app', 'Vaccine quantity'),
            'vaksina_id' => Uni::t('app', 'Vaccine ID'),
            'hayvon_turi' => Uni::t('app', 'Animal type'),
            'hayvon_rangi' => Uni::t('app', 'Animal color'),
            'hayvon_egasi' => Uni::t('app', 'Owner of animal'),
            'hayvon_egasi_turi' => Uni::t('app', 'Type of animal owner'),
            'created_at' => Uni::t('app', 'Created date'),
            'manzil' => Uni::t('app', 'Address'),
            'status' => Uni::t('app', 'Status'),
            'location_longitude' => Uni::t('app', 'Location longitude'),
            'location_latitude' => Uni::t('app', 'Location latitude'),
        ];
    }

    public function beforeSave($insert){
        if($insert){
            $this->created_at = time();
            //$this->user_id = Uni::$app->getUser()->getId();
        }else{
             //$this->user_id = Uni::$app->getUser()->getId();
             //$this->updated_date = time();
       }
        return parent::beforeSave($insert);
    }

    public function getVaksina()
    {
        return $this->hasOne(Vaksina::className(), ['id' => 'vaksina_id']);
    }
    public function getHayvonTuri()
    {
        return $this->hasOne(HayvonTuri::className(), ['id' => 'hayvon_turi']);
    }
    public function getUchastka()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'uchastka_id']);
    }
    
    public function getHayvonRangi()
    {
        return $this->hasOne(HayvonRangi::className(), ['id' => 'hayvon_rangi']);
    }
    public function getHayvonEgasiTuri()
    {
        return $this->hasOne(HayvonEgasi::className(), ['id' => 'hayvon_egasi']);
    }
    // public function getName()
    // {
    //     if(Uni::$app->language=='ru')return $this->name_ru;
    //     else return $this->name_uz;
    // }
    public function afterFind(){
        // if(is_integer($this->created_at)){
        //     $this->created_at = date('d-m-Y',$this->created_at);
        // }
    }
    public function afterSave($insert, $changedAttributes)
     {
        if ($insert === true) {
            $vktuman = VkUchastka::findOne($this->prixod_uchastka_id);
            $vktuman->ostatok = $vktuman->ostatok - $this->vaksina_miqdor;
            if($vktuman->ostatok<=$vktuman->vaksina_miqdor) $vktuman->save();
        }
        return parent::afterSave($insert, $changedAttributes);
     }

    public function search($params) {
        $query = VaksinaPerform::find()->orderBy(["id"=>SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if(isset($params['owner'])){
            $query->andFilterWhere(['like','hayvon_egasi',$params['owner']]);
        }
        if(isset($params['address'])){
            $query->andFilterWhere(['like','manzil',$params['address']]);
        }
        if(isset($params['vk_turi'])){
            $query->andFilterWhere(['=','vaksina_id',$params['vk_turi']]);
        }
        if(isset($params['hayvon_rangi'])){
            $query->andFilterWhere(['=','hayvon_rangi',$params['hayvon_rangi']]);
        }
        if(isset($params['hayvon_turi'])){
            $query->andFilterWhere(['=','hayvon_turi',$params['hayvon_turi']]);
        }
        return $dataProvider;

    }
}
