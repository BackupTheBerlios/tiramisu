<?
function admin_login_checkpass($user, $pass) {
	if( $user == 'usuario' && $pass == 'contraseņa' )
		return 1;
	else 
		return 0;
}


?>
