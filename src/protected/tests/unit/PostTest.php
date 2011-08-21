<?php
class PostTest extends CDbTestCase {

	public $fixtures = array(
		'posts' => 'Post',
	);

	public function testPost()
	{
		$oUser = new User;
		$oUser->username = 'admin';
		$oUser->password = 'admin';
		$oUser->email = 'admin@test.com';
		$oUser->save();
		// Check login function
		$this->assertTrue($oUser->validatePassword('admin'));
		$this->assertFalse($oUser->validatePassword('admin1'));
		$oUser->delete();

		$oUser = User::model()->find(array(
			'select' => 'id',
			'condition' => 'username = :username',
			'params' => array(':username' => 'admin'),
		));
		$this->assertTrue(Yii::app()->authManager->isAssigned('admin', $oUser->id));
	}
}
