<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 15:05
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "uni_drug_category".
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
class DrugCategory extends Model
{
    public static function tableName()
    {
        return 'uni_drug_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_uz'], 'required'],
            [['user_id', 'status', 'updated_at'], 'integer'],
            ['created_at', 'default', 'value' => time()],
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
            'user_id' => Uni::t('app', 'User id'),
        ];
    }

    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->getUser()->getId();
        }
        return parent::beforeSave($insert);
    }
}
