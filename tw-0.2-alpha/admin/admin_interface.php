<?
include("template.inc");

//====== procedimientos genéricos =======

// define directorio para plantillas
function admin_interface_defdir($t) {
	$t = new Template("admin/design/");
	return $t;
}

//procedimiento generico de incluir interfaz
function admin_interface_crear($archivo) {
	$t = admin_interface_defdir($t);
	$t->set_file("plantilla", "$archivo");
	$t->pparse("salida", "plantilla");
}

//=======================================

// pagina de login
function admin_interface_login() {
	admin_interface_crear("login.html");
}

// pagina de menu
function admin_interface_menu() {
	admin_interface_crear("mainmenu.html");
}

// pagina de conf blog
function admin_interface_blog() {
	admin_interface_crear("blog.html");
}

// pagina para emitir mens generico
function admin_interface_mens($men) {
	$t = admin_interface_defdir($t);
	$t->set_file("plantilla", "men.html");
	$t->set_var("mens", $men);
	$t->pparse("salida", "plantilla");
}


?>

