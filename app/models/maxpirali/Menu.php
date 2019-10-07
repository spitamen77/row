<?php

namespace app\models\maxpirali;

use Uni;
use uni\helpers\ArrayHelper;
use app\models\maxpirali\MenuTrans;

/**
 * This is the model class for table "in_menu".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property integer $template_id
 * @property integer $tree
 * @property integer $status
 * @property integer $user_id
 * @property integer $updated_date
 */
class Menu extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'status', 'user_id'], 'required'],
            [['template_id', 'tree', 'status', 'user_id', 'updated_date'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'template_id' => 'Template ID',
            'tree' => 'Tree',
            'status' => 'Status',
            'user_id' => 'User ID',
            'updated_date' => 'Updated Date',
        ];
    }
    public static function Menus($id = false)
    {
        if ($id) {
            $menu = self::find()->where(['id' => $id, 'status' => 1])->one();
            $ota = ArrayHelper::toArray($menu);
            $children = self::find()->where(['child'=>$menu->id, 'status' => 1])
            ->orderBy(['tree'=>SORT_ASC])->all();
            if ($children) {
                foreach ($children as $key => $value) {
                    $ota['children'][] = self::menus($value->id);
                }
            }
        }else{
            $menus = self::find()->where(['child' => 0, 'status' => 1])->all();
            foreach ($menus as $key => $value) {
                $ota[$value->id] = ArrayHelper::toArray($value);
                $children = self::find()->where(['child'=>$value->id, 'status' => 1])
                ->orderBy(['tree'=>SORT_ASC])->all();
                if ($children) {
                    foreach ($children as $key1 => $value1) {
                        $ota[$value->id]['children'][] = self::menus($value1->id);
                    }
                }
            }
        }
        // $menus = load($ota);
        return $ota;
    }
    public function getMenu()
    {
        return $this->hasMany(MenuTrans::className(), ['menu_id' => 'id']);
    }
    public function afterFind(){
        $result = MenuTrans::find()->where(['menu_id'=>$this->id, 'lang'=>Uni::$app->language])->asArray()->one();
        // var_dump($result); die;
        $this->title = ($result['title'])?$result['title']:$this->title;
        parent::afterFind();
    }
    public function template()
    {
        switch ($this->template_id) {
            case 1:
                $template = 'post';
                break;
            
            case 2:
                $template = 'catalog';
                break;
            
            default:
                $template = '';
                break;
        }
        return $template;
    }
}
