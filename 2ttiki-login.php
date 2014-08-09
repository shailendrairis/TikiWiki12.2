<?php
session_start();
require_once("EncryptService.php");
$eyptService = new EncryptService();
$web_config_xml = simplexml_load_file('tikiweb.config');
$wsdl = (String)$web_config_xml->children()->url;
$encUser = $eyptService->decrypt($_REQUEST['user']);
$encUser = str_replace("\0","",$encUser);
$userArray = explode(",",$encUser);
if(count($userArray)==3) {
	$user = trim($userArray[0]); 
	$client_code = trim($userArray[1]); 
	$last_login = trim($userArray[2]); 
	if(isset($_REQUEST['page']) && $_REQUEST['page']!='') {
		$page = $_REQUEST['page'];
	}
	else if(isset($_REQUEST['Page']) && $_REQUEST['Page']!='') {
		$page = $_REQUEST['Page'];
	}
	
	if(isset($wsdl) && $wsdl!="") {
		$params = array('UserID'=>$user,'ClientID'=>$client_code,'LastLoggedOn'=>$last_login);
		$my_cert_file = (String)$web_config_xml->children()->cert_file;
		$client = new SoapClient($wsdl,array('local_cert', $my_cert_file));
		$json_result = $client->GetLoggedInUserDetails($params);
		//print_r($json_result); exit;
		$json_obj = json_decode($json_result->GetLoggedInUserDetailsResult);
		$is_valid_login = $json_obj->{'IsValidLoggin'}; 
		if($is_valid_login) {
			$email = $json_obj->{'EmailID'}; 
			$is_admin = $json_obj->{'IsSuperAdmin'}; 
			if(isset($_REQUEST['user']) && $_REQUEST['user']!="") {
				$_POST['user'] = $json_obj->{'UserName'};
				$_POST['pass'] = 'dummy';
				$_POST['email'] = $email;
				$_POST['fname'] = $json_obj->{'FirstName'};;
				$_POST['lname'] = $json_obj->{'LastName'};;
				$_POST['appuserid'] = $json_obj->{'UserId'};;
				$_POST['clientid'] = $json_obj->{'ClientId'};;
				$_POST['clientcode'] = $json_obj->{'ClientCode'};
				setcookie("client_code", $client_code,time()+1800);
				if($is_admin) {
					$_POST['user_type'] = "Admins";
				}
				else {
					$_POST['user_type'] = "Registered";
				}
				$_POST['challenge'] = "dummy";
				$_POST['response'] = "dummy";
				if(isset($page) && $page!='') {
					$_POST['page'] = $page;
				}
				require_once('tiki-login.php');
			}
		}
		else {
			//if(isset($page) && $page!='') {
				$redirect = (String)$web_config_xml->children()->tocotiteurl;
				header('Location: '.$redirect);
			//}
			//header('Location: index.php');
			$_POST['user'] = $json_obj->{'UserName'};
			$_POST['pass'] = 'dummy';
			$_POST['error'] = $json_obj->{'ErrorMsg'};
			require_once('tiki-login.php');
		}
	}
}
else {
	$user = $_REQUEST['user'];
	$password = $_REQUEST['pass'];
	if(isset($_SESSION['client_code']) && $_SESSION['client_code']!="") {
		$client_code = $_SESSION['client_code'];
		setcookie("client_code", $client_code,time()+1800);
	}
	else if(isset($_COOKIE['client_code']) && $_COOKIE['client_code']!="") {
		$client_code = $_COOKIE['client_code'];
	}
	else {
		$_POST['user'] = $user ;
		$_POST['pass'] = $password;
		$_POST['error'] = "The ClientCode provided is incorrect.";
		require_once('tiki-login.php');
	}
	if(isset($wsdl) && $wsdl!="") {
		if(isset($_SESSION['attempt']) && $_SESSION['attempt']!="") {
			$_SESSION['attempt']=$_SESSION['attempt'];
		}
		else {
			$_SESSION['attempt']=0;
		}
		$params = array('UserName'=>$user,'Password'=>$password,'ClientCode'=>$client_code,'FailedLoginCount'=>$_SESSION['attempt']);
		$my_cert_file = (String)$web_config_xml->children()->cert_file;
		$client = new SoapClient($wsdl,array('local_cert', $my_cert_file));
		$json_result = $client->LogOn($params);
		//print_r($json_result); exit;
		$json_obj = json_decode($json_result->LogOnResult);
		$is_valid_login = $json_obj->{'IsValidLoggin'}; 
		if($is_valid_login) {
			$email = $json_obj->{'EmailID'}; 
			$is_admin = $json_obj->{'IsSuperAdmin'}; 
			if(isset($_REQUEST['user']) && $_REQUEST['user']!="") {
				$_POST['user'] = $json_obj->{'UserName'}; 
				$_POST['pass'] = $password;
				$_POST['email'] = $email;
				$_POST['fname'] = $json_obj->{'FirstName'};;
				$_POST['lname'] = $json_obj->{'LastName'};;
				$_POST['appuserid'] = $json_obj->{'UserId'};;
				$_POST['clientid'] = $json_obj->{'ClientId'};;
				$_POST['clientcode'] = $json_obj->{'ClientCode'};;
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
			$_SESSION['attempt']=0;
		}
		else {
			//header('Location: index.php');
			$_POST['user'] = $json_obj->{'UserName'}; 
			$_POST['pass'] = $password;
			$_POST['error'] = $json_obj->{'ErrorMsg'};
			$_SESSION['attempt']=$_SESSION['attempt']+1;
			require_once('tiki-login.php');
		}
	}
}



	//


?>