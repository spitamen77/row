<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "vk_vaksina_animal".
 *
 * @property integer $id
 * @property integer $vaksina_id
 * @property integer $amount
 * @property integer $category_id
 * @property integer $max_age
 * @property integer $min_age
 * @property string $temperatura
 * @property integer $emlash_turi
 * @property string $emlash_vaqti
 * @property string $emlash_hududi
 * @property string $hayvon_turi_yoshi
 * @property string $emlash_uchun
 * @property string $emlash_davri
 * @property string $revaksinatsiya
 * @property string $laboratoriya_diagnos
 * @property string $talab_cheklash
 * @property string $immunitet
 */
class VaksinaAnimal extends \uni\db\ActiveRecord
{
//    public $upload_file, $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vk_vaksina_animal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['vaksina_id', 'amount', 'category_id', 'max_age', 'min_age'], 'required'],
            [['vaksina_id', 'amount', 'category_id', 'max_age', 'min_age', 'emlash_turi'], 'integer'],
            [['temperatura', 'emlash_vaqti', 'emlash_hududi', 'hayvon_turi_yoshi', 'emlash_uchun', 'emlash_davri', 'revaksinatsiya', 'laboratoriya_diagnos', 'talab_cheklash', 'immunitet'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vaksina_id' => Uni::t('app', 'Vaccine'),
            'amount' => Uni::t("app",'Amount'),
            'category_id' => Uni::t("app",'Category'),
            'max_age' => Uni::t("app",'Max age'),
            'min_age' => Uni::t("app",'Min age'),
            'temperatura' => Uni::t('app', 'Temperature'),
            'emlash_turi' => Uni::t('app', 'emlash'),
            'emlash_vaqti' => Uni::t('app', 'Vaccine time'),
            'emlash_hududi' => Uni::t('app', 'Vaccine territory'),
            'hayvon_turi_yoshi' => Uni::t('app', 'Animal type and age'),
            'emlash_uchun' => Uni::t('app', 'For vaccine'),
            'emlash_davri' => Uni::t('app', 'Vaccine era'),
            'revaksinatsiya' => Uni::t('app', 'Revaccine'),
            'laboratoriya_diagnos' => Uni::t('app', 'Laboratoriya diagnos'),
            'talab_cheklash' => Uni::t('app', 'Vaccine requirements and restrictions'),
            'immunitet' => Uni::t('app', 'Immunitet'),
        ];
    }

    public function getHayvon()
    {
        return $this->hasOne(HayvonTuri::className(), ['id'=>'category_id']);
    }

    public function getVaksina()
    {
        return $this->hasOne(Vaksina::className(), ['id'=>'vaksina_id']);
    }

    public function getName()
    {
        if(Uni::$app->language=='ru')return $this->name_ru;
        else return $this->name_uz;
    }

    public function getEmlash()
    {
        if($this->emlash_turi==1) return Uni::t('app', 'Required');
        else return Uni::t('app', 'Profilaktik');
    }

}
