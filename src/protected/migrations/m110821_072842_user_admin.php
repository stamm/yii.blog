<?php

class m110821_072842_user_admin extends CDbMigration
{
	public function up()
	{
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