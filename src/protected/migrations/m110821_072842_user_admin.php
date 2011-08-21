<?php

class m110821_072842_user_admin extends CDbMigration
{
	public function up()
	{
		#var_dump($this->getDbConnection());
		/*$this->insert('{{user}}', array(
			'username' => 'admin',
			'password' => 'b1cb1d77e769c70ba6794c821c033b7a',
			'salt' => '69bdf8eb61a61bc8c79c6a0e0b998c5c',
			'email' => 'admin@test.com',
		));*/
		$oUser = new User;
		$oUser->username = 'admin';
		$oUser->password = 'admin';
		$oUser->email = 'admin@test.com';
		$oUser->save();
	}

	public function down()
	{
		return User::model()->deleteAll('username = :username', array(':username' => 'admin'));
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