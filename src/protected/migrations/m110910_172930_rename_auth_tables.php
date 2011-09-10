<?php

class m110910_172930_rename_auth_tables extends CDbMigration
{
	public function up()
	{
		$this->renameTable('AuthAssignment', 'tbl_auth_assignment');
		$this->renameTable('AuthItem', 'tbl_auth_item');
		$this->renameTable('AuthItemChild', 'tbl_auth_item_child');
	}

	public function down()
	{
		echo "m110910_172930_rename_auth_tables does not support migration down.\n";
		return false;
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