<?php

namespace app\models;

use Uni;

/**
 * This is the model class for table "uni_user_password".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $created_date
 * @property string $password
 */
class UserPassword extends \uni\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 9;

    public static function tableName()
    {
        return 'uni_user_password';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'required'],
            [['user_id', 'status', 'created_date'], 'integer'],
            ['created_date', 'default', 'value' => time()],
            [['password_reset_token'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_date' => Uni::t('app', 'Created date'),
            'password' => Uni::t('app','Password'),
        ];
    }


    public function beforeSave($insert){
        if($insert){
//            $this->user_id = Uni::$app->getUser()->getId();
        }else{
            $this->created_date = time();
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert,$attr){
        if($insert){

        }
        else {
            $users=UserModel::find()->where("uni_groups_users.group_id=7")
                ->joinWith('groupsUsers')->asArray()->all();
            $data['message']='The user changed the password';
            $data['action_page']='reference/users/view/'.$this->user_id;
            Notification::saveInstantce($users,$data);
        }
        return parent::afterSave($insert,$attr);
    }
}
