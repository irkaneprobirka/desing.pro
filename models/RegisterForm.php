<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $role_id
 * @property string $full_name
 * @property string $phone
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $auth_key
 *
 * @property Application[] $applications
 * @property Role $role
 */
class RegisterForm extends Model
{
    public string $login = '';
    public string $full_name = '';
    public string $phone = '';
    public string $password = '';
    public string $password_repeat = '';
    public string $email = '';       
    public bool $rules = false;

    public function rules()
    {
              return [
            [[ 'full_name', 'phone', 'login', 'password', 'email'], 'required'],
            [['full_name', 'phone', 'login', 'password', 'email'], 'string', 'max' => 255],
            [['login'], 'unique', 'targetClass' => User::class],
            ['full_name', 'match', 'pattern' => '/^[а-яёА-ЯЁ+\s-]+$/u'],
            ['login', 'match', 'pattern' => '/^[a-zA-Z+\-]+$/'],
            ['email', 'email'],
            // +7(XXX)-XXX-XX-XX
            //['phone', 'match', 'pattern' => "/^\+7\(\d{3}\)\-\d{3}(\-\d{2}){2}$/"],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\-\d{3}(\-\d{2}){2}$/'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['rules', 'required', 'requiredValue' => 1, 'message' => 'Согласие на обработку персональных данных - должно быть отмечено']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'full_name' => 'ФИО',
            'phone' => 'Телефон',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'rules' => 'Согласие на обработку персональных данных'
        ];
    }

    public function registerUser(){
        if ($this->validate()) {
            $user = new User();
            $user->attributes = $this->attributes;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->role_id = Role::getRoleId('user');

            if(!$user->save()){
                VarDumper::dump($user->errors, 10, true);
            }
        }
        return $user ?? false;
    }
}
