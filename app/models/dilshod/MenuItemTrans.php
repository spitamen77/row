<?php

namespace app\models\dilshod;

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
    const STATUS_ACTIVE=1;
    const STATUS_INACTIVE=0;
    const STATUS_DELETE=9;
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

    public function getLang()
    {
        return [
            'uz-UZ'=>"O`zbekcha",
            'ru-RU'=>"Русский",
            'en-US'=>"English"
        ];
    }

    public function search($params) {
        $query = MenuItemTrans::find()->orderBy(["id" => SORT_DESC]);

        $query->andFilterWhere(['like', 'title', $params['search']])
            ->andFilterWhere(['like', 'short', $params['search']])
            ->andFilterWhere(['like', 'text', $params['search']]);

        return $dataProvider;

    }

    public function getItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'item_id']);
    }

}
