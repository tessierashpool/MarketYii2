<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
   // public $authKey;
   // public $accessToken;
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
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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
			{
				if($this->password!='')
					$this->password = Yii::$app->security->generatePasswordHash($this->password);	
				else
					$this->password = $this->oldAttributes['password'];
			}
				
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
      //  $scenarios['update'] = ['username'];
 
        return $scenarios;
    }
	
    public function rules()
    {
        return [
			[['username', 'password', 'auth_key'], 'string', 'max' => 255],	
            [['username'], 'required'],
            [['password'], 'required', 'on' => 'create'],
			[['username'], 'unique'],		
        ];
    }
	
	public function getAssignmentsArray(){
		$role_assignments = Yii::$app->authManager->getAssignments($this->id);
		$role_assignments_arr = ArrayHelper::map($role_assignments, 'roleName', 'roleName');	
		return $role_assignments_arr;	
	}	

	public function getRolesArray(){
		$rbac =  Yii::$app->authManager;
		$roles = $rbac->roles;
		$roles_array  = ArrayHelper::map($roles, 'name', 'name');		
		return array_intersect($this->assignmentsArray, $roles_array);
	}	
	
	public function getPermissionsArray(){
		$rbac =  Yii::$app->authManager;
		$permissions = $rbac->getPermissionsByUser($this->id);
		$permissions_array  = ArrayHelper::map($permissions, 'name', 'name');	
		return $permissions_array;
	}	
	
	public function getRolesDescriptionsArray(){
		$roles = Yii::$app->authManager->roles;
		$roles_descrition_arr  = ArrayHelper::map($roles, 'name', 'description');
		return $roles_descrition_arr;
	}		
	
    /**
	 * Save user with auth items
	 *
     */
    public function saveAuthItem($params)
    {
		$rbac = Yii::$app->authManager;
		if($this->save())
		{
			if($this->id!=1)
			{
				$rbac->revokeAll($this->id);	
				if(is_array($params['authRoles']))			
					foreach($params['authRoles'] as $role)
					{
						$rbac->assign($rbac->getRole($role), $this->id);				
					}	
			}				
			return true;
		}
		return false;
    }		
}
