<?php

namespace app\models\dilshod;

use Uni;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $wrong_pass
 * @property string $phone
 * @property int $admin_seen
 * @property string $image
 * @property string $fio
 * @property string $tel
 * @property int $birthdate
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \uni\db\ActiveRecord
{
    const STATUS_DELETED = 0; // Если пользователь Заблокирован(Удален)
    const STATUS_ACTIVE = 10; // Если пользователь Активен
    const STATUS_IN_ACTIVE = 5; // Если пользователь Активен
    const STATUS_ADMIN = 1; // Если пользователь Администратор(для части II)
    const ADMIN_SEEN = 1; // Если пользователь Администратор(для части II)
    const ADMIN_NO_SEEN = 0; // Если пользователь Администратор(для части II)
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'wrong_pass', 'admin_seen', 'birthdate', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['image', 'fio', 'tel'], 'string', 'max' => 128],
            [['username'], 'unique', 'message'=>"Bunday user mavjud"],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'wrong_pass' => 'Wrong Pass',
            // 'phone' => 'Phone',
            'admin_seen' => 'Admin Seen',
            'image' => 'Image',
            'fio' => 'Fio',
            'tel' => 'Tel',
            'birthdate' => 'Birthdate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAdminseen()
    {
        return [
        '1' => Uni::t('app','Aktiv'),
        '0' => Uni::t('app','Nofaol'),
    ];
    }

    public function getStatus()
    {
        return [
        '10' => Uni::t('app','Aktiv'),
        '5' => Uni::t('app','Kutilmoqda'),
        '0' => Uni::t('app','Deleted'),
        // '1' => Uni::t('app','Admin'),
    ];
    }

    public static function getNew()
    {
        return self::find()->where(['admin_seen'=>self::ADMIN_NO_SEEN,'status'=>self::STATUS_IN_ACTIVE])->count();
    }

    public static function getNot()
    {
        return self::find()->where(['admin_seen'=>self::ADMIN_SEEN,'status'=>self::STATUS_IN_ACTIVE])->count();
    }
}
