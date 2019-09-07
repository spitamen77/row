<?php

namespace app\models;

use Uni;
use uni\data\ActiveDataProvider;
use uni\db\Exception;
use uni\db\Query;
use uni\helpers\ArrayHelper;

/**
 * This is the model class for table "sed_personal".
 *
 * @property integer $per_id
 * @property integer $depar_id
 * @property string $rule
 * @property string $name
 * @property string $lastname
 * @property string $middlename
 * @property string $personal_picture
 * @property string $email
 * @property string $personal_sign
 * @property string $visit
 * @property integer $logged
 * @property integer $current_module
 * @property integer $staff_number
 * @property integer $status
 * @property integer $position
 * @property integer $temp_dep
 * @property integer $temp_pos
 * @property integer $positionm
 *
 * @property SedGraduatedSchools[] $sedGraduatedSchools
 * @property SedGroupsUsers[] $sedGroupsUsers
 * @property SedPersonRelatives[] $sedPersonRelatives
 * @property SedPersonalOrders[] $sedPersonalOrders
 * @property SedReportsResponsible[] $sedReportsResponsibles
 */
class SedPersonal extends \uni\db\ActiveRecord
{
    public $hudud;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_FIRED = 2;
    const STATUS_DELETED = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sed_personal';
    }
    // public function getAttributesWithoutValue(){
    //     if(Uni::$app->controller->access('ADMIN')){
    //         return ['name','lastname','middlename','login','departmentName','staff_number','positionName'];
    //     }
    //     return ['name','lastname','middlename','departmentName','staff_number','positionName'];
    // }
    public function getHududName(){
        if($this->department){
            return $this->department->name;
        }
        return "";
    }
    
    public function rules()
    {
        return [
            [['status','phone','viloyat_id','tuman_id'], 'integer'],
            [['firstname','lastname'], 'required'],
            [['personal_picture'], 'string'],
            [['hudud'], 'safe'],
            [['firstname','lastname', 'middlename'], 'string', 'max' => 512],
            [['email'], 'string', 'max' => 100],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'per_id' => 'Per ID',
            'firstname' => Uni::t("app",'Firstname'),
            'middlename' => Uni::t("app",'Middlename'),
            'lastname' => Uni::t("app",'Lastname'),
            'email' => Uni::t("app",'Email'),
            'phone' => Uni::t("app",'Phone number'),
            'status' => Uni::t("app",'Status'),
        ];
    }
    
    public function beforeSave($insert){
        if($insert){
            if(Uni::$app->controller->access('ADMIN_TUM')||Uni::$app->controller->access('ADMIN_VIL')){
                $this->viloyat_id = Uni::$app->getUser()->identity->personal->viloyat_id;
            }
            
            if(Uni::$app->controller->access('ADMIN_TUM')){
                $this->tuman_id = Uni::$app->getUser()->identity->personal->tuman_id;
            }
            
            $this->created_at = time();
            $this->status = 1;
            
        }else{
            // $this->user_id = Uni::$app->getUser()->getId();
            // $this->updated_at = time();
        }
        //var_dump($this->depar_id);exit;
        return parent::beforeSave($insert);
    }
    /**
     * @return \Uni\db\ActiveQuery
     */
    public function getSedGroupsUsers()
    {
        return $this->hasMany(SedGroupsUsers::className(), ['user_id' => 'per_id']);
    }
    public function getHududList()
    {
        $result = "";
        $hudud = HududUchastka::find()->where(['uchastka_id'=>$this->per_id])->all();
        foreach ($hudud as $v) {
            $r = Uchastka::findOne(['id'=>$v->hudud_id]);
            $result =$result.$r->name.";";
        }
        return $result;
    }
    
    public function getUser(){
        return $this->hasOne(UserModel::className(),['per_id'=>'per_id']);
    }
    
   

    public function getStatusName(){
        switch ($this->status) {
            case 0:
                return Uni::t('app', 'Blocked');
                break;
            case 1:
                return Uni::t('app', 'Working');
                break;
            case 9:
                return Uni::t('app', 'Deleted');
                break;
            case 2:
                return Uni::t('app', 'Fired');
                break;
            default:
                return Uni::t('app', 'Undefined');
        }
    }
    
    public function getmakeFIO($staff_number=false,$letter=""){
        return ucfirst(trim($this->lastname))." ".ucfirst(mb_substr(trim($this->firstname),0,1,"UTF-8")).".".ucfirst(mb_substr(trim($this->middlename),0,1,"UTF-8")).".";
    }

    public function makeFIO($staff_number=false,$letter=""){
        return ucfirst(trim($this->lastname))." ".ucfirst(mb_substr(trim($this->firstname),0,1,"UTF-8")).".".ucfirst(mb_substr(trim($this->middlename),0,1,"UTF-8")).".";
    }
    
    public static function getFreepersons(){
        $numbers=UserModel::find()->select(["per_id"])->asArray()->all();
        $query = SedPersonal::find()->select(["lastname","per_id",'firstname','middlename','staff_number'])->where(['not in','per_id',$numbers])->all();
        $res=[];
        if($query)foreach($query as $q){
            $f=$q->lastname." ".$q->firstname." ".$q->middlename;
            if($q->staff_number){
                $f=$q->staff_number." - ".$f;
            }
            $res[$q->per_id]=$f;
        };
        return $res;

    }
    public static function getUserIdByDep($dep){
        $res=[];
        $user=SedPersonal::find()->where(["depar_id"=>$dep])->select(["per_id"])->asArray()->all();
        foreach($user as $u){
            $res[]=$u["per_id"];
        }
        return $res;
    }
    public function afterSave($insert, $changedAttributes)
    {
            if(!empty($this->hudud)){
                    
                    foreach ($this->hudud as $key => $value) {
                        if(!HududUchastka::find()->where(['hudud_id'=>$value,'uchastka_id'=>$this->per_id])->one()){
                            $hu = new HududUchastka();
                            $hu->hudud_id = $value;
                            $hu->uchastka_id = $this->per_id;
                            if(!$hu->save(false)){
                            }
                        }
                    }
            }else{
            }
       
        parent::afterSave($insert, $changedAttributes);
    }
    public function getViloyatList(){
        $viloyat = [];
        foreach (Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->all() as $v) {
            $viloyat[$v->id] = $v->name_uz;
        }
        return $viloyat;
    }
    public function actionList()
    {
        $id = $_GET['id'];
        $tuman = Hudud::find()->where(['status'=>Hudud::STATUS_ACTIVE, 'tuman_id'=>$id])->all();
        if (!empty($tuman)){
            //echo "<option>".Uni::t('app', 'Select')."...</option>";
            foreach ($tuman as $item){
                if(Uni::$app->language=='ru')echo "<option value='".$item->id."'>".$item->name_ru."</option>";
                else echo "<option value='".$item->id."'>".$item->name_uz."</option>";
            }
        }
        else echo "<option> - </option>";
    }


    public function getViloyat()
    {
        return $this->hasOne(Viloyat::className(), ['id'=>'viloyat_id']);
    }

    public function getTuman()
    {
        return $this->hasOne(Tuman::className(), ['id'=>'tuman_id']);
    }
    public function search($params,$error=false){
        $user = Uni::$app->getUser()->identity->personal;
        $query = self::find();
       
        if(Uni::$app->controller->access("ADMIN_TUM")) $query->where(['tuman_id'=>$user->tuman_id]);
        if(Uni::$app->controller->access("ADMIN_VIL")) $query->where(['viloyat_id'=>$user->viloyat_id]);
        
        
        if(isset($params['sort'])){
            if(substr($params["sort"],0,1)=="-"){
                if(isset($this->{substr($params["sort"],1)})) $query->addOrderBy([substr($params["sort"],1)=>SORT_ASC]);
            }
            else { if(isset($this->$params["sort"]))$query->addOrderBy([$params["sort"]=>SORT_DESC]);}
        }else{
            $query->addOrderBy(["per_id"=>SORT_DESC,]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize=15;
        return $dataProvider;
    }
}   
