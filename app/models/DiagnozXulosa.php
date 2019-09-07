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
class DiagnozXulosa extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    
    public static function tableName()
    {
        return 'vk_diagnoz_xulosa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['diagnoz_id', 'user_id', 'matn'], 'required'],
            [['diagnoz_id', 'status', 'created_date', 'user_id'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['matn'], 'string', 'max' => 1024],
            [['fayl'], 'file'],
            [['fayl'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diagnoz_id' => Uni::t('app', 'Diagnose'),
            'user_id' => Uni::t('app', 'User'),
            'matn' => Uni::t('app', 'Conclusion'),
            'created_date' => Uni::t('app', 'Created date'),
            'manzil' => Uni::t('app', 'Address'),
            'status' => Uni::t('app', 'Status'),
            'location_longitude' => Uni::t('app', 'Location longitude'),
            'location_latitude' => Uni::t('app', 'Location latitude'),
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

    public function getKasal()
    {
        return $this->hasOne(Kasal::className(), ['id' => 'kasal_id']);
    }
    public function getUchastka()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'uchastka_id']);
    }
    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    public function getDiagnoz()
    {
        return $this->hasOne(DiagnozPerform::className(), ['id' => 'diagnoz_id']);
    }

    public function afterFind(){
        // if(is_integer($this->created_date)){
        //     $this->created_date = date('d-m-Y',$this->created_date);
        // }
        $this->fayl=@unserialize($this->fayl);
        //$this->img=@unserialize($this->img);
        if(isset($this->fayl[0]))$this->fayl=$this->fayl[0];

    }

}
