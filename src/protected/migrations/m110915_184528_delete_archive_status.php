<?php

class m110915_184528_delete_archive_status extends CDbMigration
{
	public function up()
	{
		$this->delete('tbl_lookup', 'type = :type AND code = :code', array(
			':type' => 'PostStatus',
			':code' => 3,
		));
	}

	public function down()
	{
		echo "m110915_184528_delete_archive_status does not support migration down.\n";
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