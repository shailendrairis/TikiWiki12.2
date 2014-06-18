<?php
// (c) Copyright 2002-2013 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: extend_membership.php 44444 2013-01-05 21:24:24Z changi67 $

function payment_behavior_extend_membership( $users, $group, $periods = 1, $groupId = 0 )
{
	global $userlib;

	$users = (array) $users;

	foreach ($users as $u) {
		$userlib->extend_membership($u, $group, $periods);
		$attributelib = TikiLib::lib('attribute');
		$attributes = $attributelib->get_attributes('user', $u);

		foreach ($attributes as $a) {
			$attname = 'tiki.memberextend.' . $groupId; 
			if (isset($attributes[$attname])) {
				$attributelib->set_attribute('user', $u, $attname, '');
			}
		}
	}
}

