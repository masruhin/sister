<?php 
/**
 * the purpose I added this class is to make the file system much flexible 
 * for customization.
 * Actually,  this is a kind of interface and you should modify it to fit your system
 * @author Logan Cai (cailongqun [at] yahoo [dot] com [dot] cn)
 * @link www.phpletter.com
 * @since 4/August/2007
 */
	class Auth
	{
		var $__loginIndexInSession = 'ajax_user';
		function __construct()
		{
			
		}
		
		function Auth()
		{
			$this->__construct();
		}
		/**
		 * check if the user has logged
		 *
		 * @return boolean
		 */
		function isLoggedIn()
		{
			return (!empty($_SESSION[$this->__loginIndexInSession])?true:false);
		}
		/**
		 * validate the username & password
		 * @return boolean
		 *
		 */
		function login()
		{
/*		    include "../../../fungsi_umum/fungsi_pass.php";
            if (!isset($_SESSION['Admin'])) {
                $username = $_SESSION['Admin']['username'];
                $password = $_SESSION['Admin']['password'];	
                
                //$password = addslashes($_POST['password']);
                $cekpass  = md5(addslashes($_POST['password']));  
               // echo $username."<br>".$password;
               // exit;               
            }
            else {
                $username = $_SESSION['Admin']['username'];
                $password = $_SESSION['Admin']['password'];
                $cekpass  = hex($_POST['password'],82);    	
            }
			if($_POST['username'] == $username && $cekpass == $password)
			{ */
				$_SESSION[$this->__loginIndexInSession] = true;
				return true;
			/*}else 
			{
				return false;
			} */
		}
	}
?>