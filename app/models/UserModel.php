<?php

namespace app\models;

use app\components\Model;
use app\models\forms\LoginForm;
use Uni;
use app\components\manager\Url;
use uni\data\ActiveDataProvider;
use uni\web\IdentityInterface;
use app\components\encoder\Pbkdf2PasswordEncoder;

/**
 * This is the model class for table "auth_users".
 *
 * @property integer $id
 * @property integer $activation_code
 * @property string $password
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $salt
 * @property integer $status
 * @property integer $logged
 * @property integer $updated
 * @property integer $created
 * @property integer $wrong_pass
 * @property string $email
 * @property string $avatar
 * @property string $username
 * @property string $middlename
 * @property string $lastname
 * @property string $role
 */
class UserModel extends Model implements IdentityInterface
{

    public $perms=[];
    const USER_BLOCKED=0;
    const USER_ACTIVE=1;
    const USER_FIRED = 2;
    const USER_DELETE=9;
    public $uploadDir = 'avatars';
    public $uploadPrefix = 'avatar';
    public $notgen=["salt","logged","wrong_pass","auth_key","password_reset_token","created","updated",'status'];
    public $rpassword = null;
    public $old_password = null;
    public $new_password = null;
    public $groups;
    public $hudud;
    public static $TYPE_STD=0;
    public static $TYPE_TECH=1;
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uni_user_security';
    }
    public static function findIdentity($id) {
        $dbUser = self::find()
            ->where([
                "id" => $id
            ])
            ->one();
        if (!$dbUser) {
            return null;
        }
        return new static($dbUser);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
//    public static function findIdentityByAccessToken($token, $userType = null) {
//
//        $dbUser = self::find()
//            ->where(["accessToken" => $token])
//            ->one();
//        if (!count($dbUser)) {
//            return null;
//        }
//        return new static($dbUser);
//    }

    public static function findByUsernameOrEmail($username = false, $email = false){
        if(!$username or !$email)
            return false;

        if(!is_string($username) || !is_string($email))
            return false;

        return self::find()
                ->where(['email' => $username])
                ->orWhere(['email' => $email])
                ->count() > 0;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','email','role'], 'required'],
            [['updated','role','created','wrong_pass','activation_code','viloyat_id','tuman_id', 'status', 'expire_date'], 'integer'],
            [['logged','hudud'], 'safe'],
            [[ 'password', 'password_reset_token', 'auth_key', 'salt',], 'string', 'max' => 255],

            //[['email'], 'unique' ],
            //[['avatar'], 'string','max'=>512 ],

            [['phone','email'], 'unique' ],
            [['email'], 'email' ],
            [['username'], 'string','max'=>64 ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' =>  Uni::t('app','Parol'),
            'rpassword' =>  Uni::t('app','Repeat rassword'),
            'password_reset_token' =>Uni::t('app','Password Reset Token'),
            'auth_key' => Uni::t('app','Auth key'),
            'salt' => Uni::t('app','Salt'),
            'status' => Uni::t('app','Status'),
            'logged' => Uni::t('app','Logged'),
            'updated' => Uni::t('app','Tahrirlangan sana'),
            'created' => Uni::t('app','Yaratilgan sana'),
            'email' => Uni::t('app','Pochta'),
            'role' => 'User role',
            'wrong_pass' => Uni::t('app','unsuccessful attempt'),
            'activation_code' => Uni::t('app','Account activation code'),
            'username' => Uni::t('app','Foydalanuvchi nomi'),
            // 'firstname' => Uni::t('app','First name'),
            // 'lastname' => Uni::t('app','Last name'),
            // 'middlename' => Uni::t('app','Middle name'),
            // 'phone' => Uni::t('app','Phone'),
            'viloyat_id' => Uni::t('app','Region'),
            'tuman_id' => Uni::t('app','District'),
        ];
    }

    public static function findByUsername($username){
        return static::findOne(['email' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }
    public static function findByRole($role)
    {
        return static::find()
            ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
            ->where(['auth_assignment.item_name' => $role->name]);
    }
    public function getHududList()
    {
        $result = "";
        $hudud = HududUchastka::find()->where(['uchastka_id'=>$this->id])->all();
        foreach ($hudud as $v) {
            $r = Uchastka::findOne(['id'=>$v->hudud_id]);
            $result =$result."<span class='uk-badge uk-badge-primary'>".$r->name."</span><br>";
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    public function beforeValidate(){
        if(is_array($this->avatar))$this->avatar=@serialize($this->avatar);
        return parent::beforeValidate();
    }
    public function beforeSave($insert){
        if($insert){
            $this->created = time();
            $this->status = 1;
            // if(!Uni::$app->access('ADMIN')){
            //     $user = Uni::$app->getUser()->identity;
            //     $this->viloyat_id = $user->viloyat_id;
            //     $this->tuman_id = $user->tuman_id;
            // }

        }
        return parent::beforeSave($insert);
    }

    public function validatePassword($user) {

        $encoder = new Pbkdf2PasswordEncoder();
        return $encoder->isPasswordValid($this->password,$user->password,$this->salt);
    }

    public function validatePasswordByPass($password) {
        $encoder = new Pbkdf2PasswordEncoder();
//        echo $password;exit;
        return $encoder->isPasswordValid($this->password,$password,$this->salt);
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enabaleAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function setPassword($new_password){
        $this->salt = Uni::$app->security->generateRandomString();
        $encoder = new Pbkdf2PasswordEncoder();
        $this->password = $encoder->encodePassword($new_password,$this->salt);
    }

    /**
     * eslab qoluvchi uchun key, remember me key
     * */
    public function generateAuthKey(){
        $this->auth_key= Uni::$app->security->generateRandomString();
    }
    /**
     * token buyicha search uchun
     * */

    public static function findByPasswordResetToken($token){
        if (empty($token)) {
            return false;
        }
        $expire = Uni::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    /**
     *
     *
     **/
    public static function isPasswordResetTokenValid($token){
        if(empty($token))return false;
        $expire=Uni::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    public static function generatePasswordToken(){
        return Uni::$app->security->generateRandomString()."_".time();
    }
    public function removePasswordToken(){
        $this->password_reset_token=null;
    }
    public  function afterLogin(){

        $this->wrong_pass= 0;
        $this->save();
    }
    public function afterFind()
    {
        //$this->viloyat_id = $this->personal->viloyat_id;
        //$this->tuman_id = $this->personal->tuman_id;
        $this->avatar=@unserialize($this->avatar);
        if(isset($this->avatar[0]))$this->avatar=$this->avatar[0];
    }
    public  function afterPassValidate(){
        if($this->wrong_pass==LoginForm::M_WRONG)$this->status=0;
        if($this->wrong_pass<LoginForm::M_WRONG) $this->wrong_pass= $this->wrong_pass+1;
        $this->save(false);
    }
    public function afterValidate(){
        return parent::afterValidate();
    }

    public function makeFIO(){
        return ucfirst(trim($this->lastname))."&nbsp;".ucfirst(mb_substr(trim($this->username),0,1)).".".ucfirst(mb_substr(trim($this->middlename),0,1));
    }

    public function search($params,$error=false){
        $query = UserModel::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination->pageSize=15;
        if(isset($params['UserModel']['groups'])) {
            $users=GroupsUsers::find()->select(["user_id"])->where(["group_id"=>$params['UserModel']['groups']])->all();
            $arr=[];if(is_array($users))foreach($users as $u){$arr[]=$u->user_id;}$query->andFilterWhere(["id"=>$arr]);
        }
        if(isset($params['sort'])){
            if(substr($params["sort"],0,1)=="-"){
                if(isset($this->{substr($params["sort"],1)})) $query->addOrderBy([substr($params["sort"],1)=>SORT_ASC]);
            }
            else { if(isset($this->$params["sort"]))$query->addOrderBy([$params["sort"]=>SORT_DESC]);}
        }else{
            $query->addOrderBy(["id"=>SORT_DESC,]);
        }
        return $dataProvider;
    }

    public function getDropDownProp($prop)
    {
        return false;
    }
    public function getGroupsUsers()
    {
        return $this->hasMany(GroupsUsers::className(), ['user_id' => 'id']);
    }

    public function getRoles()
    {
        return $this->hasOne(Groups::className(), ['id' => 'role']);
    }

    public function getProfileStatus()
    {
        return $this->status;
    }

    public function getUchastka()
    {
        return $this->hasOne(VkUchastka::className(), ['uchastka_id'=>'id']);
    }

    public function getVkuchas()
    {
        return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id']);
    }

    public function getSumma()
    {
        return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id'])->where(['status'=>VkUchastka::STATUS_ACTIVE])->sum('vaksina_miqdor');
    }

    public function getKutish()
    {
        return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id'])->where(['status'=>VkUchastka::STATUS_INACTIVE])->sum('vaksina_miqdor');
    }

    public function getQoldiq()
    {
        return $this->hasMany(VkUchastka::className(), ['uchastka_id' => 'id'])->where(['status'=>VkUchastka::STATUS_ACTIVE])->sum('ostatok');
    }
    public function getPersonal(){
        return $this->hasOne(SedPersonal::className(),['per_id' => 'per_id']);
    }

    public function getViloyat()
    {
        return $this->hasOne(Viloyat::className(), ['id'=>'viloyat_id']);
    }

    public function getTuman()
    {
        return $this->hasOne(Tuman::className(), ['id'=>'tuman_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            $group = new GroupsUsers();
            $group->user_id = $this->id;
            $group->group_id = $this->role;
            $group->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
