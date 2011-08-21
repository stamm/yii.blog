<?php

class m110821_080536_rbac_roles extends CDbMigration
{
	public function up()
	{
		$iUserId = User::model()->find(array(
			'select' => 'id',
			'condition' => 'username = :username',
			'params' => array(':username' => 'admin'),
		))->id;
		$auth = Yii::app()->authManager;
		$auth->createRole('admin');
		$auth->assign('admin' ,$iUserId);
	}

	public function down()
	{
		Yii::app()->authManager->clearAll();
		return true;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}