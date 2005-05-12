<?PHP
//include "escritura.php";
include "template.inc";

// ### Inicializador de las plantillas
// :::::::especifica los archivos de templates k se van a usar
function interface_plantilla_abrir($seccion) {

	$t = new Template("tema/");

	if($seccion == "portada") {
		$t->set_file("plantilla", "index.html");
	}
	if($seccion == "blog") {
		$t->set_file("plantilla", "blog.html");
	}

	return $t;
}

// Establece los bloques para blog
// Sirve para establecer todos los bloques al principio 
//
function interface_bloques_blog( $t ) {
	$t->set_block("plantilla", "comentario", "coment"); //añade los bloques de comentarios 

	$t->set_block('plantilla', 'slist', 'tb');//anula bloque slist
	$t->set_block("plantilla", "addnew", "ad");			
	$t->set_block('plantilla', 'fullblog', 'tabla');


	return $t;
}





//#### imprime la portada
// --la variable pagina indica la pagina (portada, blog, album,...) 
// de la que se mostrará la portada
function interface_portada($pagina, $contenido) {

	$t = interface_plantilla_abrir($pagina);
	$t->set_block('plantilla', 'slist', 'tabla');

	$t = interface_variables_ambiente($t);

	for($cont1=0 ; $contenido[$cont1] != NULL; $cont1++) {
		if($contenido[$cont1]["tipo"] == "blog"){ 
			$t = interface_blog_short($t, $cont1,$contenido);
		}
		else
		if($contenido[$cont1]["tipo"] == "estatico");
			//interface_estatico_short();
		else
		if($contenido[$cont1]["tipo"] == "album");
			//interface_album_short()
	}
	
	//eliminamos bloques sobrantes
	$t->set_block('plantilla', 'fullblog', 'tb');



	$t->pparse("salida", "plantilla");
}


//#### Imprime short blog
function interface_blog_short($t, $cont, $contenido) {
		$t->set_var("ref", "blog.php?blog=".$contenido[$cont]["ref"]);
		$t->set_var("titulo", $contenido[$cont]["titulo"]);
		$t->set_var("fecha", $contenido[$cont]["fecha"]);
		$t->set_var("cont", $contenido[$cont]["blog"]);

		$t->parse("tabla", "slist", true);


		return $t;
}



// #### funcion Imprime full blog
function interface_blog_full($contenido) {
	$t = interface_plantilla_abrir("blog");
	$t = interface_variables_ambiente($t);
	$t = interface_bloques_blog($t);
	if(isset($contenido['ref'])){
		$t->set_var("full_titulo", $contenido["titulo"]);
		$t->set_var("full_fecha", $contenido["fecha"]);
		$t->set_var("full_cont", $contenido["blog"]);
		$t->set_var("full_post", $contenido["post"]);
		$t->parse("tabla", "fullblog", true);

		$t = interface_comentarios_full($t, "blog", $contenido);
	}
	else {
		$t->set_var("alert", "<H2>El Articulo no existe !</H2>");
	}


	$t->pparse("salida", "plantilla");
}





// #### funcion Muestra el bloque de paginador 
function interface_paginador( $t ) {

	$t->set_block("plantilla", "posterior", "ps");
	$t->set_block("plantilla", "anterior", "at");
	if(!isset($_GET['page']) )
		$page = 0;
	else
		$page = $_GET['page'];
	$t->set_var("ant-link", "?page=".($page + 1));
	if($page > 0){
		$t->set_var("post-link", "?page=".($page - 1));
		$t->parse("ps", "posterior", true);
	}
	$t->set_var("page", $page+1);
	$t->parse("at", "anterior", true);
	
	return $t;
}



// ##### Asigna las variables de ambiente, como links, etc ...
function interface_variables_ambiente($t) {

	$t->set_var("link_blog", "blog.php");
	$t->set_var("link_estatico", "estatic.php");
	$t->set_var("link_portafolio", "portfolio.php");

	//variables de cambio de pagina

	if(isset($_GET['blog'])) {
		$t->set_block("plantilla", "posterior", "ps");
		$t->set_block("plantilla", "anterior", "at");
	}
	else
		$t = interface_paginador( $t );

	return $t;
}

// ++++++++++ Sistema de comentarios ++++++

// #### Funcion principal de comentarios <-- Editando ...
function interface_comentarios_full($t, $tipo, $contenido) {

		if(isset($_POST['content']) && isset($_POST['mail']) ) {
			interface_comentarios_write($tipo, $contenido);
		}
		else
			$t = interface_comentarios_new($t);


		if($contenido["comentarios"] != 0 ||
		  ($_POST['content'] || $_POST['mail'])) {
			$t->parse("tb", "coment", true);
			$t = interface_comentarios_print($t, $tipo, $contenido["ref"]);
		}

			

		return $t;
}


// #### Interfaz nuevo comentario 
function interface_comentarios_new($t) {
	$t->set_var("post", "");
	$t->set_var("mail", "mail");
	$t->set_var("content", "content");
	$t->set_var("send", "send");
	$t->parse("ad", "addnew", 'true');

	return $t;
}

// #### Interfaz imprime comnentario 
function interface_comentarios_print($t, $tipo, $ref) {
	$l = lectura_comentarios($tipo, $ref);
	for($c = 0;isset($l[$c]) ; $c++) {
			$t->set_var("email-coment", $l[$c]['email']);
			$t->set_var("fecha-coment", $l[$c]['fecha']);
			$t->set_var("content-coment", $l[$c]['contenido']);
			$t->parse("coment", "comentario", 'true');
	
	}
	return $t;
}


// #### Interfaz escribe comentario 
function interface_comentarios_write($tipo, $contenido){
	$contenido["content"] = $_POST["content"];
	$contenido["email"] = $_POST["mail"];
	$contenido["seccion"] = $tipo;
	escritura_comentario($contenido);
}

?>
