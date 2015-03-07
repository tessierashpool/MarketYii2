<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;
class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;
/*
    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
   /* public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }*/

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
		return Yii::$app->security->validatePassword($password,$this->password);		
    }
	
	public static function tableName()
	{
		return 'user';
	}	

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
		
			if ($this->isAttributeChanged('password'))
				$this->password = Yii::$app->security->generatePasswordHash($this->password);		
				
			if ($this->isNewRecord)
				$this->auth_key = Yii::$app->security->generateRandomString(255);
				
			return true;
		} else {
			return false;
		}
	}
	
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        //$scenarios['create'] = ['username', 'password'];
 
        return $scenarios;
    }
	
    public function rules()
    {
        return [
			[['username', 'password', 'auth_key'], 'string', 'max' => 255],	
            [['username', 'password'], 'required'],
			[['username'], 'unique'],		
        ];
    }
}
