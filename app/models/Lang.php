<?php

namespace app\models;

use Uni;
use uni\helpers\ArrayHelper;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $defaultl
 * @property integer $date_update
 * @property integer $date_create
 */
class Lang extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'name', 'date_update', 'date_create'], 'required'],
            [['defaultl', 'date_update', 'date_create'], 'integer'],
            [['url', 'local', 'name'], 'string', 'max' => 255]
        ];
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'uni\behaviors\TimestampBehavior',
                'attributes' => [
                    \uni\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \uni\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'local' => 'Local',
            'name' => 'Name',
            'defaultl' => 'Default',
            'date_update' => 'Date Update',
            'date_create' => 'Date Create',
        ];
    }

    static $current = null;

    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

//Установка текущего объекта языка и локаль пользователя
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
       // var_dump(self::$current);exit;
        Uni::$app->language = self::$current->url;
    }


    static function getDefaultLang()
    {
        return Lang::find()->where("defaultl = :default", [":default" => 1])->one();
    }
    static function getLangByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $language = Lang::find()->where('url = :url', [':url' => $url])->one();
            if ( $language === null ) {
                return null;
            }else{
                return $language;
            }
        }
    }
    public static function getDropDown(){
        $items=self::find(['url',"name"])->all();
        return ArrayHelper::map($items,"url","name");
    }
}
