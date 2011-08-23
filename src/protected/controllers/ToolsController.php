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
}