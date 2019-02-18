<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password',], 'required'],
            [['username', 'password', 'auth_key', 'access_token'], 'string', 'max' => 45],
            [['is_admin'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $user = self::findOne($id);

        return (isset($user->id)) ? $user : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['access_token' => $token]);

        return (isset($user->id)) ? $user : null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::findOne(['username' => $username]);

        return (isset($user->id)) ? $user : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function isAdmin(){
        return $this->is_admin;
    }
}
