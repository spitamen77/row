<?php

namespace app\models\forms;

use app\components\encoder\Pbkdf2PasswordEncoder;
use Uni;
use app\components\logger\CustomTarget;
use app\models\UserModel;
use uni\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    const M_WRONG=5;
    public $password;
    public $email;
    public $phone;
    public $rememberMe = true;
    private $count=0;
    public $userblock=false;
    private $_user = false;
    private $five=false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['email', 'password'], 'required'],

            ['rememberMe', 'boolean'],

            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'salt' => 'Salt',
            'status' => 'Status',
            'logged' => 'Logged',
            'updated' => 'Updated At',
            'created' => 'Created At',
            'wrong_pass' => 'Неудачная попытка',
            'role' => 'Role',
            'branch_id' => 'Project',
            'rememberMe' => 'Запомнить'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this)) {
                if(!$this->userblock)$this->addError($attribute, 'Неверное имя пользователя или пароль.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {

        if ($this->validate()) {
            $this->getUser()->logged=time();
            $this->getUser()->save(false);

            return Uni::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[phone]]
     *
     * @return UserModel|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UserModel::findByUsername($this->email);
           // var_dump($this->_user);exit;
            if($this->_user)$this->count=1;
            if($this->_user&&$this->_user->status==0){
                $this->five=false;
                $this->addError("userblock","Пользователь заблокирован");
                return false;
            }
        }
        return $this->_user;
    }



    public function afterValidate(){
        if($this->errors) {
            if($this->getUser() && $this->count==1){
                $this->_user->afterPassValidate();
                if($this->_user&&$this->_user->status==0){
                    $this->addError("userblock",$this->userblock="Пользователь заблокирован");
                    $this->five=true;
                    $this->userblock=true;
                }elseif($this->_user&&$this->_user->wrong_pass>=0&&$this->_user->wrong_pass< self::M_WRONG){
                    $this->userblock=true;
                    $this->addError("userblock",($this->_user->wrong_pass). "  неуспешный попыток.");
                }
                elseif($this->_user && $this->_user->wrong_pass==self::M_WRONG){
                    $this->addError("userblock",$this->userblock=self::M_WRONG."  неуспешный попыток.Пользователь заблокирован");
                    $this->five=false;
                }

            }
            foreach ($this->errors as $error) {

            }
        }
        else{
            if(!is_object($this->_user)){
                $this->userblock=true;
                $this->addError("userblock","Персонал не найдено из учет кадров, связанных с этим пользователем.");
            }else{
                $this->_user->afterLogin();
                CustomTarget::authlog($this->email,$this->password,"Success");
            }

        }

    }
}
