<?php

include("functions/bd.php");	
include("functions/escritura.php");

function admin_blog_main() {
	if ($_POST['titulo'] != NULL) {
		$cont= escribir_blog(
					$_POST["titulo"],
					$_POST["cont1"], 
					$_POST["cont2"],
					$_POST["portada"]);
		echo admin_interface_mens("
						Enviado con Exito <br>
						<a href='admin.php?section=blog'> <b> Volver </b> </a>
					");
	}
	else
		admin_interface_blog();
}

?>
