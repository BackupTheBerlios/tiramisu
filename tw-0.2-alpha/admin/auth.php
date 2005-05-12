<?
function admin_login_checkpass($user, $pass) {
	if( $user == 'usuario' && $pass == 'contraseña' )
		return 1;
	else 
		return 0;
}


?>
