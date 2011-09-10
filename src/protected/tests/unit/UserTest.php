<?php
class UserTest extends CDbTestCase {

	public $fixtures = array(
		'tbl_auth_assignment'=>':tbl_auth_assignment',
		'tbl_auth_item'=>':tbl_auth_item',
		'tbl_auth_item_child'=>':tbl_auth_item_child',
		'users' => 'User',
	);

	public function testExists()
	{

		$this->assertTrue(false);
		//die;
		//$this->assertEquals(, 1);
	}

	public function testCreate()
	{
		$oUser = new User;
		$oUser->username = 'new';
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
			'params' => array(':username' => 'new'),
		));
		$this->assertTrue(Yii::app()->authManager->isAssigned('new', $oUser->id));
	}
}
