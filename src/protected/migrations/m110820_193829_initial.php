<?php

class m110820_193829_initial extends CDbMigration
{
	public function up()
	{
		$this->execute('
CREATE TABLE `tbl_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `status` int(11) unsigned NOT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  `author` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `post_id` int(11) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_post` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

		$this->execute('CREATE TABLE `tbl_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;');

		$this->execute('INSERT INTO `tbl_lookup`(`id`,`name`,`code`,`type`,`position`) values 
		(1,"Черновик",1,"PostStatus",1),
		(2,"Опубликовано",2,"PostStatus",2),
		(3,"В архиве",3,"PostStatus",3),
		(4,"Ждут проверки",1,"CommentStatus",1),
		(5,"Проверенные",2,"CommentStatus",2),
		(6,"Спам",3,"CommentStatus",3);');


		$this->execute('CREATE TABLE `tbl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `content_display` text NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `post_time` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `short_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_url` (`url`),
  KEY `FK_post_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');



		$this->execute('CREATE TABLE `tbl_post_tag` (
  `tag_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  KEY `i_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

		$this->execute('CREATE TABLE `tbl_social` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `access_token` varchar(100) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

		$this->execute('CREATE TABLE `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `frequency` int(11) DEFAULT "1",
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

		$this->execute('CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `profile` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

	}

	public function down()
	{
		echo "m110820_193829_initial does not support migration down.\n";
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