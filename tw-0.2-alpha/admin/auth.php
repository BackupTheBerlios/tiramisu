<?
function admin_login_checkpass($user, $pass) {
	if( $user == 'usuario' && $pass == 'contrase�a' )
		return 1;
	else 
		return 0;
}


?>
