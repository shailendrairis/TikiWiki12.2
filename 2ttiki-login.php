<?php
session_start();
require_once("EncryptService.php");
$eyptService = new EncryptService();
$web_config_xml = simplexml_load_file('web.config');
$wsdl = (String)$web_config_xml->children()->url;
$encUser = $eyptService->decrypt($_REQUEST['user']);
$userArray = explode(",",$encUser);
if(count($userArray)==3) {
	$user = $userArray[0];
	$client_code = $userArray[1];
	$last_login = $userArray[2];
	if(isset($wsdl) && $wsdl!="") {
		$params = array('UserID'=>$user,'ClientID'=>$client_code,'LastLoggedOn'=>$last_login);
		$client = new SoapClient($wsdl);
		$json_result = $client->GetLoggedInUserDetails($params);
		$json_obj = json_decode($json_result->GetLoggedInUserDetailsResult);
		$is_valid_login = $json_obj->{'IsValidLoggin'}; 
		if($is_valid_login) {
			$email = $json_obj->{'EmailID'}; 
			$is_admin = $json_obj->{'IsSuperAdmin'}; 
			if(isset($_REQUEST['user']) && $_REQUEST['user']!="") {
				$_POST['user'] = $json_obj->{'UserName'};
				$_POST['pass'] = $password;
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
			//header('Location: index.php');
			$_POST['user'] = $json_obj->{'UserName'};
			$_POST['pass'] = $password;
			$_POST['error'] = $json_obj->{'ErrorMsg'};
			require_once('tiki-login.php');
		}
	}
}
else {
	$user = $_REQUEST['user'];
	$password = $_REQUEST['pass'];
	if(isset($_SESSION['client_code']) && $_SESSION['client_code']!="") {
		$clientcode = $_SESSION['client_code'];
	}
	else {
		$_POST['user'] = $user ;
		$_POST['pass'] = $password;
		$_POST['error'] = "Invalid Login";
		require_once('tiki-login.php');
	}
	if(isset($wsdl) && $wsdl!="") {
		$params = array('UserName'=>$user,'Password'=>$password,'ClientCode'=>$client_code,'FailedLoginCount'=>"0");
		$client = new SoapClient($wsdl);
		$json_result = $client->LogOn($params);
		$json_obj = json_decode($json_result->LogOnResult);
		$is_valid_login = $json_obj->{'IsValidLoggin'}; 
		if($is_valid_login) {
			$email = $json_obj->{'EmailID'}; 
			$is_admin = $json_obj->{'IsSuperAdmin'}; 
			if(isset($_REQUEST['user']) && $_REQUEST['user']!="") {
				$_POST['user'] = $json_obj->{'UserName'}; 
				$_POST['pass'] = $password;
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
			//header('Location: index.php');
			$_POST['user'] = $json_obj->{'UserName'}; 
			$_POST['pass'] = $password;
			$_POST['error'] = $json_obj->{'ErrorMsg'};
			require_once('tiki-login.php');
		}
	}
}



	//


?>