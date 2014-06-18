<?php

//$req_uri = explode("/",$_SERVER['REQUEST_URI']); 
//$client_code = $req_uri[1];
$client_code = $_REQUEST['client'];
$user = $_REQUEST['user'];
$password = $_REQUEST['pass'];
$wsdl = "http://a19c32c9f6734e2c910e05c5d64ebed6.cloudapp.net/services/CloudTikiWikiService.svc?wsdl";
$params = array('UserName'=>$user,'Password'=>$password,'ClientCode'=>$client_code,'FailedLoginCount'=>"0");
$client = new SoapClient($wsdl);
$json_result = $client->LogOn($params);
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