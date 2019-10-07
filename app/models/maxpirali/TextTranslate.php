<?php

namespace app\models\maxpirali;

use Uni;

/**
 * This is the model class for table "in_text_translate".
 *
 * @property integer $id
 * @property string $lang
 * @property string $slug
 * @property string $text
 * @property integer $status
 * @property integer $updated_date
 */
class TextTranslate extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in_text_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang', 'slug', 'text'], 'required'],
            [['status', 'updated_date'], 'integer'],
            [['lang', 'slug', 'text'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lang' => 'Lang',
            'slug' => 'Slug',
            'text' => 'Text',
            'status' => 'Status',
            // 'updated_date' => 'Updated Date',
        ];
    }
}
