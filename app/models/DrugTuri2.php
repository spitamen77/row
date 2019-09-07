<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 15:07
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "uni_drug_turi".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_uz
 * @property integer $status
 * @property integer $user_id
 * @property integer $category_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property GroupsModules[] $sedGroupsModules
 * @property GroupsUsers[] $sedGroupsUsers
 */
class DrugTuri extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return 'uni_drug_turi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_uz'], 'required'],
            [['user_id', 'status', 'updated_at', 'category_id'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['category_id', 'default', 'value' => time()],
            [['name_ru', 'name_uz'], 'string', 'max' => 128]
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
            'created_at' => Uni::t('app', 'Created time'),
            'updated_at' => Uni::t('app', 'Update time'),
            'user_id' => Uni::t('app', 'User'),
        ];
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasMany(DrugCategory::className(), ['category_id' => 'id']);
    }

    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->getUser()->getId();
        }else{
            $this->user_id = Uni::$app->getUser()->getId();
            $this->updated_at = time();
        }
        return parent::beforeSave($insert);
    }

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }

}
