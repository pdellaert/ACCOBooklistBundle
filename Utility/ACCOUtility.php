<?php
namespace Dellaert\ACCOBooklistBundle\Utility;

class ACCOUtility {
	public static function verifyReferer($ref,$val) {
		preg_match("/https?:\/\/([a-zA-Z0-9\-\.]+)/", $ref, $matches);
		if( count($matches) > 1 && $matches[1] == $val ) {
			return true;
		}
		return false;
	}
}
