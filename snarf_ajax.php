<?php
/**
 * @package tikiwiki
 */
// (c) Copyright 2002-2013 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: snarf_ajax.php 44444 2013-01-05 21:24:24Z changi67 $

require_once ('tiki-setup.php');
include_once('lib/wiki-plugins/wikiplugin_snarf.php');

if ($prefs['wikiplugin_snarf'] != 'y') {
	echo tra('Feature disabled');
	die;
}
echo wikiplugin_snarf('', $_REQUEST);
