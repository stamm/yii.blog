<?php
class LookupTest extends CDbTestCase {

	public function testPost()
	{
		$db = Yii::app()->db;
		$this->assertEquals(
			Lookup::model()->countByAttributes(array('type' => 'PostStatus')),
			3
		);
	}
}
