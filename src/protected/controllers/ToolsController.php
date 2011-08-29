<?php

class ToolsController extends Controller
{
	/**
	 * Preview markitup
	 * @return void
	 */
	public function actionMarkitup()
	{
		$sHtml = @$_POST['data'];
		$sHtml = Post::render($sHtml);
		$this->renderText($sHtml);
	}

	public function actionTagsAutocomplete()
	{
		$sQuery = Yii::app()->getRequest()->getParam('query');

		if (Yii::app()->request->isAjaxRequest && $sQuery)
		{
			echo CJSON::encode(Tag::getTags($sQuery));
			Yii::app()->end();
		}
	}
}