<?php
// (c) Copyright 2002-2013 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: socialnetworks.php 50762 2014-04-11 16:24:07Z jonnybradley $

function prefs_socialnetworks_list()
{
	return array(
		'socialnetworks_twitter_consumer_key' => array(
			'name' => tra('Consumer key'),
			'description' => tra('Consumer key generated by registering your site as an application at Twitter'),
			'type' => 'text',
			'keywords' => 'social networks',
			'size' => 40,
			'default' =>'',
		),
		'socialnetworks_twitter_consumer_secret' => array(
			'name' => tra('Consumer secret'),
			'description' => tra('Consumer secret generated by registering your site as an application at Twitter'),
			'keywords' => 'social networks',
			'type' => 'text',
			'size' => 60,
			'default' => '',
		),
		'socialnetworks_facebook_application_secr' => array(
			'name' => tra('Application secret'),
			'description' => tra('Application secret generated by registering your site as an application at Facebook'),
			'keywords' => 'social networks',
			'type' => 'text',
			'size' => 60,
			'default' => '',
		),
		'socialnetworks_facebook_application_id' => array(
			'name' => tra('Application ID'),
			'description' => tra('Application id generated by registering your site as an application at Facebook'),
			'keywords' => 'social networks',
			'type' => 'text',
			'size' => 60,
			'default' => '',
		),
		'socialnetworks_facebook_login' => array(
			'name' => tra('Login using Facebook'),
			'description' => tra('Allow users to login using Facebook'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
		'socialnetworks_facebook_autocreateuser' => array(
			'name' => tra('Auto-create Tiki user'),
			'description' => tra('Automatically create a Tiki user by the username of fb_xxxxxxxx for users logging in using Facebook if they do not yet have a Tiki account. If not, they will be asked to link or register a Tiki account'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'dependencies' => array(
				'socialnetworks_facebook_login',
			),
			'default' => 'n',
		),
		'socialnetworks_facebook_firstloginpopup' => array(
			'name' => tra('Require Facebook users to enter local account info'),
			'description' => tra('Require Facebook users to enter local account info, specifically email and local login name'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'dependencies' => array(
				'socialnetworks_facebook_login',
				'socialnetworks_facebook_autocreateuser',
			),
			'default' => 'n',
		),
		'socialnetworks_facebook_offline_access' => array(
			'name' => tra('Tiki can access Facebook at any time'),
			'description' => tra('Even when user is not logged onto Facebook, Tiki can access it.'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
		'socialnetworks_facebook_publish_stream' => array(
			'name' => tra('Tiki can post to Wall'),
			'description' => tra('Tiki may post status messages, notes, photos, and videos to Facebook Wall'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
		'socialnetworks_facebook_manage_events' => array(
			'name' => tra('Tiki can manage events'),
			'description' => tra('Tiki may create and RSVP to Facebook events'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
		'socialnetworks_facebook_manage_pages' => array(
			'name' => tra('Tiki can manage pages'),
			'description' => tra('Tiki may manage user pages'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
		'socialnetworks_facebook_sms' => array(
			'name' => tra('Tiki can SMS'),
			'description' => tra('Tiki may SMS via Facebook'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
		'socialnetworks_facebook_email' => array(
			'name' => tra('Tiki can get email'),
			'description' => tra("Tiki can request the user's email"),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
		'socialnetworks_bitly_login' => array(
			'name' => tra('bit.ly Login'),
			'description' => tra('Site wide login (username) for bit.ly'),
			'keywords' => 'social networks',
			'type' => 'text',
			'size' => 60,
			'default' => '',
		),
		'socialnetworks_bitly_key' => array(
			'name' => tra('bit.ly Key'),
			'description' => tra('Site wide API key for bit.ly'),
			'keywords' => 'social networks',
			'type' => 'text',
			'size' => 60,
			'default' => '',
		),
		'socialnetworks_bitly_sitewide' => array(
			'name' => tra('Use site-wide account'),
			'description' => tra('When setting this option to yes, only the site wide account will be used for all users'),
			'keywords' => 'social networks',
			'type' => 'flag',
			'default' => 'n',
		),
	);
}
