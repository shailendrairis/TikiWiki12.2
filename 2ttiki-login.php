<?php
$client_ID = $_REQUEST['clientid'];
$user_ID = $_REQUEST['userid'];
$wsdl = "http://a19c32c9f6734e2c910e05c5d64ebed6.cloudapp.net/services/CloudTikiWikiService.svc?wsdl";
$params = array('userID'=>$user_ID,'ClientID'=>$client_ID);
$client = new SoapClient($wsdl);
$json_result = $client->GetLoggedInUserDetails($params);
$json_obj = json_decode($json_result->LogOnResult);
$is_valid_login = $json_obj->{'IsValidLoggin'}; 
if($is_valid_login) {
	$email = $json_obj->{'EmailID'}; 
	$is_admin = $json_obj->{'IsSuperAdmin'}; 
	if(isset($_REQUEST['user']) && $_REQUEST['user']!="") {
		$_POST['user'] = $user ;
		$_POST['pass'] = 'dummy';
		$_POST['email'] = $email;
		if($is_admin) {
			$_POST['user_type'] = "Admins";
		}
		else {
			$_POST['user_type'] = "Registered";
		}
		$_POST['challenge'] = "dummy";
		$_POST['response'] = "dummy";
		require_once('tiki-login.php');
	}
}
else {
	header('Location: index.php');
}
//


?>