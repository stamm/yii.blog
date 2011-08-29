<?php
/**
 * Class for escaping string
 */
class Escape
{
	static function escapeHtml($sText)
	{
		$oMarkdown = new CMarkdown();
		$oPurifier = new CHtmlPurifier();
		return $oPurifier->purify(
			$oMarkdown->transform($sText)
		);
	}
}
 
