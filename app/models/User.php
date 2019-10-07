<?php

namespace app\models;

use Uni;
use uni\base\NotSupportedException;
use uni\db\ActiveRecord;
use uni\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    // Сейчас в переопределяемых методах ниже возвращаются ID или логины только те, у которых 'status' равен константе SCATUS_ACTIVE
    const STATUS_DELETED = 0; // Если пользователь Заблокирован(Удален)
    const STATUS_ACTIVE = 10; // Если пользователь Активен
    const STATUS_ADMIN = 1; // Если пользователь Администратор(для части II)

    public function beforeSave($insert){
        if($insert){
            // $this->user_id = Uni::$app->getUser()->getId();
        }else{
             // $this->user_id = Uni::$app->getUser()->getId();
             $this->updated_at = time();
       }
        return parent::beforeSave($insert);
    }
    
    // Переопределяем методы для интерфейса
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Uni::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Uni::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Uni::$app->security->generateRandomString();
    }
}