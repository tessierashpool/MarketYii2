<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * Prepare Roles&pErmissions array to filter
     *
     * @return array
     */
    public function getRoles()
    {
        // bypass scenarios() implementation in the parent class
        return ['1'=>'Role','2'=>'Permission'];
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'match', 'pattern' => '/^[a-zA-Z_]*$/i', 'message' => Yii::t('error','Latin characters and underscore only')],
            ['name', 'unique'],
            [['name', 'type'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }
	
    /**
	 * Save new auth item
	 *
     * @return boolen
     */
    public function saveAuthItem($params)
    {
		$rbac = Yii::$app->authManager;
		if($this->validate())
		{
			if($this->type==1)
			{
				$role = $rbac->createRole($this->name);
				$role->description = $this->description;
				return $rbac->add($role)&&$this->addChildRoles($params['authRoles'], $role)&&$this->addChildPermissions($params['authPermissions'], $role);			
			}
			else
			{
				$permission = $rbac->createPermission($this->name);
				$permission->description = $this->description;
				return $rbac->add($permission)&&$this->addChildPermissions($params['authPermissions'], $permission);			
			}
		}
		return false;
    }	
	
    public function addChildRoles($roles, $item)
    {
		$rbac = Yii::$app->authManager;
		$allRolesInSistem = $rbac->roles;
		if(is_array($roles))
			foreach($roles as $role)
			{
				$rbac->addChild($item, $allRolesInSistem[$role]);
			}
		return true;
    }	
	
    public function addChildPermissions($permissions, $item)
    {
		$rbac = Yii::$app->authManager;
		$allPermissionsInSistem = $rbac->permissions;
		if(is_array($permissions))
			foreach($permissions as $permission)
			{
				$rbac->addChild($item, $allPermissionsInSistem[$permission]);
			}
		return true;
    }		
	
    /**
	 * Delete auth item from DB
	 *
     */
    public function deleteAuthItem()
    {
		$rbac = Yii::$app->authManager;
		if($this->type==1)
		{
			$role = $rbac->getRole($this->name);
			return $rbac->remove($role);				
		}
		else
		{
			$permission = $rbac->getPermission($this->name);
			return $rbac->remove($permission);			
		}
    }	

    /**
	 * Update auth item
	 *
     */
    public function updateAuthItem($params)
    {
		$rbac = Yii::$app->authManager;
		if($this->validate())
		{
			$old_name = $this->oldAttributes['name'];
			if($this->type==1)
			{	
				$role = $rbac->createRole($this->name);
				$role->description = $this->description;
				$rbac->removeChildren($rbac->getRole($old_name));
				return $rbac->update($old_name,$role)&&$this->addChildRoles($params['authRoles'], $role)&&$this->addChildPermissions($params['authPermissions'], $role);				
			}
			else
			{
				$permission = $rbac->createPermission($this->name);
				$permission->description = $this->description;
				$rbac->removeChildren($rbac->getPermission($old_name));
				return $rbac->update($old_name,$permission)&&$this->addChildPermissions($params['authPermissions'], $permission);			
			}
			return true;
		}
		return false;
    }	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }
	
	public function getRolesArray(){
		$rbac =  Yii::$app->authManager;
		$roles = $rbac->roles;
		$roles_array  = ArrayHelper::map($roles, 'name', 'name');
		ArrayHelper::remove($roles_array, $this->name);
		ArrayHelper::remove($roles_array, 'admin');
		foreach($roles_array as $key=>$role)
		{	
			if($rbac->hasChild($rbac->getRole($role),$rbac->getRole($this->name)))
				unset($roles_array[$key]);
		}
		return $roles_array;
	}
	
	public function getPermissionsArray(){
		$rbac =  Yii::$app->authManager;
		$permissions = $rbac->permissions;
		$permissions_array  = ArrayHelper::map($permissions, 'name', 'name');
		ArrayHelper::remove($permissions_array, $this->name);
		foreach($permissions_array as $key=>$permission)
		{	
			if($rbac->hasChild($rbac->getPermission($permission),$rbac->getPermission($this->name)))
				unset($permissions_array[$key]);
		}		
		return $permissions_array;
	}	
	
	public function getRolesDescriptionsArray(){
		$roles = Yii::$app->authManager->roles;
		$roles_descrition_arr  = ArrayHelper::map($roles, 'name', 'description');
		return $roles_descrition_arr;
	}	

	public function getPermissionsDescriptionsArray(){
		$permissions = Yii::$app->authManager->permissions;
		$permissions_descrition_arr  = ArrayHelper::map($permissions, 'name', 'description');
		return $permissions_descrition_arr;	
	}	
	
	public function getAssignmentsArray(){
		$role_assignments = Yii::$app->authManager->getChildren($this->name);
		$role_assignments_arr = ArrayHelper::map($role_assignments, 'name', 'name');	
		return $role_assignments_arr;	
	}	
	
	/*public function getPermissionsArray(){
		$roles = Yii::$app->authManager->roles;
		$permissions = Yii::$app->authManager->permissions;
		$roles_array  = ArrayHelper::map($roles, 'name', 'name');
		ArrayHelper::remove($roles_array, $model->name);
		ArrayHelper::remove($roles_array, 'admin');
		$permissions_array  = ArrayHelper::map($permissions, 'name', 'name');
		ArrayHelper::remove($permissions_array, $model->name);
		global $roles_descrition_arr, $permissions_descrition_arr;
		$roles_descrition_arr  = ArrayHelper::map($roles, 'name', 'description');
		$permissions_descrition_arr  = ArrayHelper::map($permissions, 'name', 'description');

		$role_assignments = Yii::$app->authManager->getChildren($model->name);
		$role_assignments_arr = ArrayHelper::map($role_assignments, 'name', 'name');	
	}		*/
}
