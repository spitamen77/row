<?php

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "uni_groups".
 *
 * @property integer $id
 * @property string $groupp
 * @property string $title
 * @property integer $active
 * @property string $created
 *
 * @property GroupsModules[] $sedGroupsModules
 * @property GroupsUsers[] $sedGroupsUsers
 */
class Groups extends Model
{
    public $notgen=['created','id'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupp', 'title', 'active', 'created'], 'required'],
            [['active'], 'integer'],
            [['created'], 'safe'],
            [['group', 'title'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupp' => 'Group',
            'title' => 'Title',
            'active' => 'Active',
            'created' => 'Created',
        ];
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getGroupsModules()
    {
        return $this->hasMany(GroupsModules::className(), ['group_id' => 'id']);
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getGroupsUsers()
    {
        return $this->hasMany(GroupsUsers::className(), ['group_id' => 'id']);
    }
    public function getDropDownProp($prop)
    {$data["multiple"]="false";
        switch($prop){

            case "active":
                $data["arr"]="\\app\\models\\Groups::getDropDownActive()";
                break;
            default: return false;
        }
        return $data;

    }
    public static function getDropDownActive(){
        $re["multiple"]="false";

            return ['0' => 'disabled', '1' => 'enabled'];

    }
    public static function getDrop(){
        $res=[];
      $all =Groups::find()->all();
        foreach($all as $l){
            $res[$l->id]=$l->title;
        }
        return $res;
    }

}
