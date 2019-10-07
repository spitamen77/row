<?php

namespace app\models\maxpirali;

use Uni;

/**
 * This is the model class for table "in_menu_item_trans".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $lang
 * @property string $title
 * @property string $short
 * @property string $text
 * @property integer $status
 * @property integer $updated_date
 */
class MenuItemTrans extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in_menu_item_trans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'lang', 'title', 'text'], 'required'],
            [['item_id', 'status', 'updated_date'], 'integer'],
            [['text'], 'string'],
            [['lang', 'title'], 'string', 'max' => 128],
            [['short'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'lang' => 'Lang',
            'title' => 'Title',
            'short' => 'Short',
            'text' => 'Text',
            'status' => 'Status',
            'updated_date' => 'Updated Date',
        ];
    }
}
