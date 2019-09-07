<?php
namespace app\modules\nextadmin\modules\text\models;

use Uni;
use app\modules\nextadmin\behaviors\CacheFlush;

class Text extends \app\modules\nextadmin\components\ActiveRecord
{
    const CACHE_KEY = 'next_text';

    public static function tableName()
    {
        return 'next_texts';
    }

    public function rules()
    {
        return [
            ['text_id', 'number', 'integerOnly' => true],
            ['text', 'required'],
            ['text', 'trim'],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Uni::t('app', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique']
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => Uni::t('app', 'Text'),
            'slug' => Uni::t('app', 'Slug'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className()
        ];
    }
    public function getTranslation(){
        return $this->hasMany(TextTranslation::className(),['text_id'=>'text_id'])->indexBy('language');
    }
}