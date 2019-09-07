<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "source_message".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 */
class SourceMessage extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Uni::t('app', 'ID'),
            'category' => Uni::t('app', 'Category'),
            'message' => Uni::t('app', 'Message'),
        ];
    }

    /**
     * @return \uni\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }
    public static function getCatList(){
        return["app"=>"Frontend","next"=>"Backend"];
    }
}
