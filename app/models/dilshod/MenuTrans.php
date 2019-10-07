<?php

namespace app\models\dilshod;

use Uni;

/**
 * This is the model class for table "in_menu_trans".
 *
 * @property int $id
 * @property int $menu_id
 * @property string $lang
 * @property string $title
 * @property int $updated_date
 */
class MenuTrans extends \uni\db\ActiveRecord
{
    const STATUS_ACTIVE=1;
    const STATUS_INACTIVE=0;
    const STATUS_DELETE=9;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'in_menu_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id', 'lang', 'title'], 'required'],
            [['menu_id', 'status','updated_date'], 'integer'],
            [['lang', 'title'], 'string', 'max' => 128],
        ];
    }

    public function beforeSave($insert){
        if($insert){
//            $this->child = 0;
            $this->status = self::STATUS_ACTIVE;
        }else{
            // $this->user_id = Uni::$app->user->identity->id;
            $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'lang' => 'Lang',
            'title' => 'Title',
            'updated_date' => 'Updated Date',
        ];
    }
}
