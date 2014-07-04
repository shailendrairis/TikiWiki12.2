<?PHP //	© 2009 Lowry Computer Products, Inc.  All rights reserved.

class EncryptService{	

	function EncryptService(){
		set_time_limit(-1);
	}
	
	function encrypt($string) {
        //Key
        //$key = "lowrycom";
        //Encryption
		$web_config_xml = simplexml_load_file('tikiweb.config');
		$key = (String)$web_config_xml->children()->key;
        $cipher_alg = MCRYPT_TRIPLEDES;
        $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
        $encrypted_string = mcrypt_encrypt($cipher_alg, $key, $string, MCRYPT_MODE_ECB, $iv);
        $encrypted_string = base64_encode($encrypted_string);
        return $encrypted_string;
    }

    function decrypt($string) {
        $string = str_replace("~cloud~","/",str_replace("~Upsafety~","+",str_replace("~2Tech~","=",$string)));
		$string = str_replace("--cloud--","/",str_replace("--Upsafety--","+",str_replace("--2Tech--","=",$string)));
		$string = base64_decode($string);
        //key
        //key = "lowrycom";
		$web_config_xml = simplexml_load_file('tikiweb.config');
		$key = (String)$web_config_xml->children()->key;
        $cipher_alg = MCRYPT_TRIPLEDES;
        $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
        $decrypted_string = mcrypt_decrypt($cipher_alg, $key, $string, MCRYPT_MODE_ECB, $iv);
        return trim($decrypted_string);
    }

    function encryptADconfig($ldaphost, $dc, $serviceUser, $serviceUserPassword){ 
    	$ldaphost = $this->encrypt($ldaphost);
    	$dc = $this->encrypt($dc);
    	$serviceUser = $this->encrypt($serviceUser);
    	$serviceUserPassword = $this->encrypt($serviceUserPassword);
    	$string = <<<_
<?php
\$validateFromActiveDirectory = 1;
\$ldaphost = "$ldaphost";
\$dc = "$dc";
\$serviceUser = "$serviceUser";
\$serviceUserPassword = "$serviceUserPassword";
?> 
_;
		return $string;
 
    
    }
    
    function encryptDBconfig($New_DB_Name, $DBServer_IP, $DBServer_User, $DBServer_Pass){
    	/*
     		<?PHP $New_DB_Name = '9QagiYP7uMk=';$DBServer_IP='j0fXtGpd9yg=';$DBServer_User='QbdZXC5Xly0=';$DBServer_Pass='Z3A7UD1QhzQ='; ?> 
		*/
    	$New_DB_Name = $this->encrypt($New_DB_Name);
    	$DBServer_IP = $this->encrypt($DBServer_IP);
    	$DBServer_User = $this->encrypt($DBServer_User);
    	$DBServer_Pass = $this->encrypt($DBServer_Pass);
    	$string = <<<_
<?PHP \$New_DB_Name = '$New_DB_Name';\$DBServer_IP='$DBServer_IP';\$DBServer_User='$DBServer_User';\$DBServer_Pass='$DBServer_Pass'; ?>
_;
		return $string;
    	
    }

}

?>