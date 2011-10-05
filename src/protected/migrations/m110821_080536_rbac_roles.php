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
		$this->insert('AuthItem', array(
			'name' => 'admin',
			'type' => '2',
			'description' => '',
			'bizrule' => null,
			'data' => 'N;',
		));
		$this->insert('AuthAssignment', array(
			'itemname' => 'admin',
			'userid' => $iUserId,
		));
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