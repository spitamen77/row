<?php

namespace app\models;

use Uni;

class HududUchastka extends \uni\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'vk_hudud_uchastka';
    }
    
    public function rules()
    {
        return [
            [['hudud_id', 'uchastka_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hudud_id' => 'Hudud ID',
            'uchastka_id' => Uni::t("app",'Uchastka ID'),
            
        ];
    }
}
