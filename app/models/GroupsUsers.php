<?php

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "uni_groups_users".
 *
 * @property integer $user_id
 * @property integer $group_id
 *
 * @property UserModel $user
 * @property Groups $group
 */
class GroupsUsers extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_groups_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'required'],
            [['user_id', 'group_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'group_id' => 'Group ID',
        ];
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Personal::className(), ['per_id' => 'user_id']);
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
        return false;
    }
}
