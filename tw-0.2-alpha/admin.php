<?
//##################### admin.php ################
//	Página principal de administración
//################################################
include("admin/auth.php");
include("admin/menu.php");


session_start();

if( $_GET['logout'] == 1) {
		unset($_SESSION['auth']);
}

if(isset($_SESSION['auth'])) 
	login($_SESSION['auth']);
else {
	if (isset($_POST['pass']) && isset($_POST['user'])) { 
		$_SESSION['auth'] = admin_login_checkpass($_POST['user'] ,$_POST['pass']);
		login($_SESSION['auth'] );
	}
	else 
		admin_interface_login();
}


// Si la autentificacion tiene exito muestra menu, de lo 
// contrario muestra error login
function login($auth) {

	if( $auth == 1 ) 
		admin_menu($_GET['section']);
	
	else
		 if( $auth == 0 ) {
			admin_interface_mens("Autentificacion fallida <br> <a href='admin.php?logout=1'><b>REINTENTAR</b></a>");
			session_destroy();
		}
}
?>

