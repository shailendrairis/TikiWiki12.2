<?php
// (c) Copyright 2002-2013 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: tiki-userupload.php 44444 2013-01-05 21:24:24Z changi67 $

$section = 'mytiki';

require_once ('tiki-setup.php');
if ( $prefs['feature_use_fgal_for_user_files'] == 'y' && $user != '' ) {
	$filegallib = TikiLib::lib('filegal');
	$idGallery = $filegallib->get_user_file_gallery();

	// redirect user in correct gallery
	header('location: tiki-upload_file.php?galleryId='.$idGallery);
}
