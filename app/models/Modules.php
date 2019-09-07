<?php

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "uni_modules".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property integer $active
 * @property string $icon
 * @property integer $sort
 * @property string $created
 *
 * @property GroupsModules[] $sedGroupsModules
 */
class Modules extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_modules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title', 'active',], 'required'],
            [['active', 'sort'], 'integer'],
            [['created'], 'safe'],
            [['code', 'icon'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'description' => 'Description',
            'active' => 'Active',
            'icon' => 'Icon',
            'sort' => 'Sort',
            'created' => 'Created',
        ];
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getGroupsModules()
    {
        return $this->hasMany(GroupsModules::className(), ['module_id' => 'id']);
    }
    public function getDropDownProp($prop)
    {
    }
    public function checkModuleforGroup($group){
       $rel= GroupsModules::find()->where(['group_id'=>$group,'module_id'=>$this->id])->one();
        if($rel) return true; return false;
    }
}
