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
 * This is the model class for table "vk_diagnoz_perform".
 *
 * @property integer $id
 * @property integer $uchastka_id
 * @property integer $kasal_id
 * @property integer $kasal_daraja
 * @property string $location_longitude
 * @property string $location_latitude
 * @property integer $status
 * @property integer $created_date
 * @property string $xulosa
 * @property string $manzil
 *
 */
class DiagnozPerform extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    
    public static function tableName()
    {
        return 'vk_diagnoz_perform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uchastka_id', 'kasal_id', 'kasal_daraja', 'location_longitude', 'location_latitude',], 'required'],
            [['uchastka_id', 'status', 'created_date', 'kasal_id', 'kasal_daraja','viloyat_id','tuman_id'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['location_longitude', 'location_latitude'], 'string', 'max' => 100],
            [['xulosa'], 'string', 'max' => 2048],
            [['manzil','hayvon_rasm'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kasal_id' => Uni::t('app', 'kasal_id'),
            'kasal_daraja' => Uni::t('app', 'Kasal Daraja'),
            'xulosa' => Uni::t('app', 'Conclusion'),
            'created_date' => Uni::t('app', 'Created date'),
            'manzil' => Uni::t('app', 'Address'),
            'status' => Uni::t('app', 'Status'),
            'location_longitude' => Uni::t('app', 'Location longitude'),
            'location_latitude' => Uni::t('app', 'Location latitude'),
        ];
    }

    public function beforeSave($insert){
        if($insert){
            //$this->user_id = Uni::$app->getUser()->getId();
        }else{
            //$this->user_id = Uni::$app->getUser()->getId();
//            $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert,$attr){
        if($insert){
            $user = UserModel::find()->where(['id'=>$this->uchastka_id])->one();
            $users=UserModel::find()->orWhere(['role'=>19])->orWhere(['role'=>21])->orWhere(['role'=>22, 'viloyat_id'=>$user->viloyat_id])->orWhere(['role'=>23, 'tuman_id'=>$user->tuman_id])->asArray()->all();
            $data['message']='New disease';
            $data['action_page']='diagnose';
            Notification::saveInstantce($users,$data);

        }
        return parent::afterSave($insert,$attr);
    }

    public function getKasal()
    {
        return $this->hasOne(Kasal::className(), ['id' => 'kasal_id']);
    }
    public function getViloyat()
    {
        return $this->hasOne(Viloyat::className(), ['id' => 'viloyat_id']);
    }
    public function getTuman()
    {
        return $this->hasOne(Tuman::className(), ['id' => 'tuman_id']);
    }
    public function getUchastka()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'uchastka_id']);
    }
     public function getXulosaga()
    {
        return $this->hasMany(DiagnozXulosa::className(), ['diagnoz_id' => 'id'])->orderBy(['id'=>SORT_DESC]);
    }

    public function search($params) {
        $user = Uni::$app->getUser()->identity;

        if(Uni::$app->controller->access('LAB')||Uni::$app->controller->access('ADMIN')||Uni::$app->controller->access('HEAD'))
            $query = DiagnozPerform::find()->where(['status'=>DiagnozPerform::STATUS_ACTIVE])->orWhere(['status'=>DiagnozPerform::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC]);
        if(Uni::$app->controller->access('LAB_VIL')||Uni::$app->controller->access('ADMIN_VIL'))
            $query = DiagnozPerform::find()->where(['viloyat_id'=>$user->viloyat_id])->where(['status'=>DiagnozPerform::STATUS_ACTIVE])->orWhere(['status'=>DiagnozPerform::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC]);
        if(Uni::$app->controller->access('LAB_TUM')||Uni::$app->controller->access('ADMIN_TUM'))
            $query = DiagnozPerform::find()->where(['tuman_id'=>$user->tuman_id])->where(['status'=>DiagnozPerform::STATUS_ACTIVE])->orWhere(['status'=>DiagnozPerform::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        if(isset($params['degree'])){
            $query->andFilterWhere(['=','kasal_daraja',$params['degree']]);
        }
        if(isset($params['vil'])){
            $query->andFilterWhere(['=','viloyat_id',$params['vil']]);
        }
        if(isset($params['kas'])){
            $query->andFilterWhere(['=','kasal_id',$params['kas']]);
        }
        return $dataProvider;

    }


}
