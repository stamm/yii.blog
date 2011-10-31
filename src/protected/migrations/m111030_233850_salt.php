<?php

class m111030_233850_salt extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn('{{user}}', 'password', 'VARCHAR(60)  NOT NULL  DEFAULT ""');
		$this->alterColumn('{{user}}', 'salt', 'VARCHAR(22)  NOT NULL  DEFAULT ""');

		$this->update('{{user}}',
			array(
				'password' => '$2a$12$zwCJDpdxyBsnQJilkBMhtuIpskCz59XbTWdxn4xREBXbUh4NP2pKu',
				'salt' => 'zwCJDpdxyBsnQJilkBMht5',
			),
			'username = :username',
			array(
				'username' => 'admin',
			)
		);

		$this->createIndex('u_email', '{{user}}', 'email', true);

	}

	public function safedown()
	{
		echo "m111030_233850_salt does not support migration down.\n";
		return false;
	}
}