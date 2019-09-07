<?php

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "uni_groups_modules".
 *
 * @property integer $group_id
 * @property integer $module_id
 *
 * @property Modules $module
 * @property Groups $group
 */
class GroupsModules extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_groups_modules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'module_id'], 'required'],
            [['group_id', 'module_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'module_id' => 'Module ID',
        ];
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Modules::className(), ['id' => 'module_id']);
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }
    public function getDropDownProp($prop)
    {
        // TODO: Implement getDropDownProp() method.
    }
}
