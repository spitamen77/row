<?php

namespace app\models\dilshod;

use app\models\Lang;
use app\models\dilshod\MenuTrans;
use Uni;

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
    const STATUS_ACTIVE=1;
    const STATUS_INACTIVE=0;
    const STATUS_DELETE=9;
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
            [['title', 'slug', ], 'required'],
            ['slug', 'unique', 'message'=>"Slug mavjud"],
            [['template_id', 'tree','child', 'status', 'user_id', 'updated_date'], 'integer'],
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
            'template_id' => Uni::t('app','Template'),
            'tree' => Uni::t('app','Navbati'),
            'status' => 'Status',
            'user_id' => 'User ID',
            'updated_date' => 'Updated Date',
        ];
    }

    public function beforeSave($insert){
        if($insert){
            $this->user_id = Uni::$app->user->identity->id;
        }else{
            $this->user_id = Uni::$app->user->identity->id;
            $this->updated_date = time();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){
        if ($this->status==0) {
            $menu = MenuTrans::find()->where(['menu_id'=>$this->id])->all();
            if (!empty($menu)) {
                foreach ($menu as $key => $value) {
                    $value->status = MenuTrans::STATUS_INACTIVE;
                    $value->save(false);
                }
            }
        }
        else {
            $menu = MenuTrans::find()->where(['menu_id'=>$this->id])->all();
            if (!empty($menu)) {
                foreach ($menu as $key => $value) {
                    $value->status = MenuTrans::STATUS_ACTIVE;
                    $value->save(false);
                }
            }
        }
        if ($insert) {
            $trans = new MenuTrans();
            $trans->menu_id = $this->id;
            $trans->lang = "uz-UZ";
            $trans->title = $this->title;
            $trans->save();
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    public function getMenu()
    {   
        $list = ['0'=>Uni::t('app','Main menu')];
        $menu = self::find()->where(['child'=>0, 'status'=>self::STATUS_ACTIVE])->all();
        foreach ($menu as $key => $value) {
            $list["$value->id"] = $value->title;
            # code...
        }
        return $list;
    }

    public function getStatus()
    {
        return [
        '1' => Uni::t('app','Aktiv'),
        '0' => Uni::t('app','Nofaol'),
    ];
    }

    public function getTemplate()
    {
        return [
        '1' => Uni::t('app','Post'),
        '2' => Uni::t('app','Catalog'),
    ];
    }

    public function getOta($id)
    {
        $ota = self::find()->where(['id'=>$id])->one();
        return $ota->title;
    } 

    public function getMenuTrans($id)
    {
        return MenuTrans::find()->where(['menu_id'=>$id, 'status'=>self::STATUS_ACTIVE])->all();
    }
}
