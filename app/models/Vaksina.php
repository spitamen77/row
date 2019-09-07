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
use uni\web\ForbiddenHttpException;

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
 */
class Vaksina extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;
    const VK_SEND=0;
    const VK_RECEIVED=1;
    const VK_DENIED=2;
    const VK_NOTSEEN=3;
    public $power = [];

//    public function init(){
//        if(!Uni::$app->controller->access('PREP')){
//            throw new ForbiddenHttpException();
//        }
//    }
    public static function tableName()
    {
        return 'vk_vaksinatsiya';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_uz', 'vk_turi', 'unit_id', 'doza'], 'required'],
//            [['mol','qoy','tovuq','mushuk'],'safe'],
            [['file'], 'file'],
            [['file'],'safe'],
            [['user_id', 'status', 'updated_date'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['name_ru', 'name_uz', 'doza', 'mol', 'tovuq', 'qoy', 'mushuk'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => Uni::t('app', 'Name in russian'),
            'name_uz' => Uni::t('app', 'Name in uzbek'),
            'vk_turi' => Uni::t('app', 'Vaccine type'),
            'unit_id' => Uni::t('app', 'Unit'),
            'doza' => Uni::t('app', 'Dose'),
            'created_date' => Uni::t('app', 'Created time'),
            'updated_date' => Uni::t('app', 'Update time'),
            'user_id' => Uni::t('app', 'User id'),
            'count' => Uni::t('app', 'Count'),
            'file' => Uni::t('app', 'File'),
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


//    public function afterSave($insert, $changedAttributes)
//    {
//        parent::afterSave($insert, $changedAttributes);
//        $model = new VaksinaAnimal();
//        $model->vaksina_id = $this->id;
//        $model->category_id = $this->vk_turi;
//        $model->save();
//    }

     public function getTuri()
     {
         return $this->hasOne(VaksinaTuri::className(), ['id' => 'vk_turi']);
     }

    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    public function getPrixod()
    {
        return $this->hasOne(Prixod::className(), ['id' => 'vaksina_id']);
    }

    public function getUser()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'user_id']);
    }
    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }

    public function getAnimal()
    {
        return $this->hasMany(VaksinaAnimal::className(), ['vaksina_id'=>'id']);
    }
    public function search($params) {
        $query = Vaksina::find()->orderBy(['id'=>SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if(isset($params['name']))$query->andFilterWhere(['like','name_uz',$params['name']])
            ->orFilterWhere(['like','name_ru',$params['name']]);
        if(isset($params['vk_turi'])){
            $query->andFilterWhere(['=','vk_turi',$params['vk_turi']]);
        }

        return $dataProvider;

    }
}
