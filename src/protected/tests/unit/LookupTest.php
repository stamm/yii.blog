<?php
class LookupTest extends CDbTestCase {

	public function testPost()
	{
		$db = Yii::app()->db;
		$this->assertTrue(Lookup::model()->count(array('conditions')));
	}
}
