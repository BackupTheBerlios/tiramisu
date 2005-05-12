<?
include_once("admin_interface.php");
include("admin_blog.php");


function admin_menu($seccion) {
	if ($seccion=='blog')
		admin_blog_main();
	else 
		admin_interface_menu();
}



?>

