<?php

namespace app\models\dilshod;

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
    const STATUS_ACTIVE=1;
    const STATUS_INACTIVE=0;
    const STATUS_DELETE=9;
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
            [['slug', 'text'], 'required'],
          //  [['slug'], 'unique','message'=>Uni::t('app',"Bunday slug mavjud")],
            [['status', 'updated_date'], 'integer'],
            [['lang', 'slug', 'text'], 'string', 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lang' => Uni::t('app','til'),
            'slug' => Uni::t('app','kalit'),
            'text' => Uni::t('app','matn'),
            'status' => 'Status',
            'updated_date' => Uni::t('app','Taxrirlangan sana'),
        ];
    }

    public function beforeSave($insert){
        if($insert){
            // $this->lang = 'uz-UZ';
        }else{
            $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }


}
