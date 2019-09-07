<?php

namespace app\modules\nextadmin\modules\text\models;

use Uni;

/**
 * This is the model class for table "next_text_translation".
 *
 * @property integer $id
 * @property integer $text_id
 * @property string $language
 * @property string $text
 */
class TextTranslation extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'next_text_translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'language', 'text'], 'required'],
            [['text_id'], 'integer'],
            [['text'], 'string'],
            [['language'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text_id' => 'Text ID',
            'language' => 'Language',
            'text' => 'Text',
        ];
    }
}
