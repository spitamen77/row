<?php

namespace app\models;

use app\components\Model;
use Uni;

/**
 * This is the model class for table "configuration".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Configuration extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_configuration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    public function getDropDownProp($prop)
    {
        // TODO: Implement getDropDownProp() method.
    }
}
