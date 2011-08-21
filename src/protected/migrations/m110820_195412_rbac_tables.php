<?php

class m110820_195412_rbac_tables extends CDbMigration
{
	public function up()
	{
		$this->createTable('AuthItem', array(
			'name'=>'varchar(64) not null PRIMARY KEY',
			'type'=>'integer not null',
			'description'=>'text',
			'bizrule'=>'text',
			'data'=>'text',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->createTable('AuthItemChild', array(
			'parent'=>'varchar(64) not null',
			'child'=>'varchar(64) not null',
			'primary key (parent,child)',
			'foreign key (parent) references AuthItem (name) on delete cascade on update cascade',
			'foreign key (child) references AuthItem (name) on delete cascade on update cascade',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->createTable('AuthAssignment', array(
			'itemname'=>'varchar(64) not null',
			'userid'=>'varchar(64) not null',
			'bizrule'=>'text',
			'data'=>'text',
			'primary key (itemname,userid)',
			'foreign key (itemname) references AuthItem (name) on delete cascade on update cascade',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function down()
	{
		echo "m110820_195412_rbac_tables does not support migration down.\n";
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