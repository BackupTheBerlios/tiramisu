<?
//==============================================================
//	Gestión comun con la base de datos
//==============================================================

//------------------------------abrir_bd (); -------------------
// Abre y selecciona la base de datos
//--------------------------------------------------------------

function bd_abrir() {

	$vinculo = mysql_connect("localhost", "usr", "password")
   		or die("No pude conectar con la base de datos " . mysql_error());
	mysql_select_db("web") 	or die("Error al abrir la base de datos");

	return $vinculo;
}

//------------------------------abrir_bd (); -------------------
// Comprueba la ultima referencia de una tabla
//--------------------------------------------------------------
function bd_comprobar_ultimo($tabla) {
	$vinculo = bd_abrir();
	$consulta = "SELECT * FROM `$tabla` WHERE 1 ORDER BY `ref` DESC";
	$resultado = mysql_query( $consulta );
	$linea = mysql_fetch_array($resultado, MYSQL_ASSOC);
	return $linea["ref"];


}



//==============================================================
//	Gestion de consultas de lectura
//==============================================================


//---------------------------- bd_portada_leer();---------------
// consulta base de datos, tabla portada 
//--------------------------------------------------------------
function bd_portada_leer() {

	$vinculo = bd_abrir();
	$consulta = "SELECT * FROM `portada` WHERE 1 ORDER BY `ref` DESC";
	$resultado = mysql_query( $consulta );
	for ($a = 0; $linea = mysql_fetch_array($resultado, MYSQL_ASSOC); $a++) {
		$b = 0;
		foreach( $linea as $res[$a][$b] )
			$b++;
	}
	mysql_free_result( $resultado );
	mysql_close( $vinculo );

	return ( $res );
}

//---------------------------- bd_lista_seccion($seccion);---------------
// 	lista el numero de archivos disponibles en una sección ['numero']
//  y la referencia de cada uno de ellos ['refs']
//--------------------------------------------------------------
function bd_lista_seccion($seccion) {
	$res["numero"]=0;
	$vinculo = bd_abrir();
	$consulta = "SELECT ref FROM `".$seccion."` WHERE 1 ORDER BY `ref` DESC";
	$resultado = mysql_query( $consulta );
	for ($a = 0; $linea = mysql_fetch_assoc($resultado); $a++) {
		$res["refs"][$a]= $linea["ref"];
		$res["numero"]++;
	}
	mysql_free_result( $resultado );
	mysql_close( $vinculo );

	return ( $res );
}


//------------------------ bd_tabla_blog( referencia); ---------
//Portada para un articulo de Blog
//--------------------------------------------------------------
function bd_leer_blog($ref) {

	$vinculo = bd_abrir();
	$consulta = "SELECT * FROM blog WHERE ref=".$ref;
	$resultado = mysql_query( $consulta );
	$linea = mysql_fetch_array($resultado, MYSQL_ASSOC);
	mysql_free_result( $resultado );
	mysql_close( $vinculo );
	
	return $linea;
}

//---------------------------- bd_lista_comentarios($seccion, $ref);---------------
// 	lista el numero de comentarios disponibles para un articulo ['numero']
//  y la referencia de cada uno de ellos ['refs']
//--------------------------------------------------------------
function bd_lista_comentarios($seccion, $ref) {
	$res["numero"]=0;
	$vinculo = bd_abrir();
	$consulta = "SELECT ref FROM `comentarios`
				 WHERE seccion = '$seccion'
					AND ref_seccion = '$ref'
				 ORDER BY `ref` DESC";
	$resultado = mysql_query( $consulta );
	for ($a = 0; $linea = mysql_fetch_assoc($resultado); $a++) {
		$res["refs"][$a]= $linea["ref"];
		$res["numero"]++;
	}
	mysql_free_result( $resultado );
	mysql_close( $vinculo );

	return ( $res );
}



//---------- bd_leer_comentario(referencia) --------
//	Lee todos los comentarios de un articuo
//------------------------------------------------------------
function bd_leer_comentario($ref) {
	
	$vinculo = bd_abrir();
	$consulta = "
				SELECT * FROM `comentarios`
					WHERE ref = '$ref'
				";
	$resultado = mysql_query( $consulta );
	$linea = mysql_fetch_array($resultado, MYSQL_ASSOC);
	mysql_free_result( $resultado );
	mysql_close( $vinculo );

	return ( $linea );


}


//======================================================
//	Gestion de Escritura
//===========================================

//------------------- db_escribir_portada(); -------------------
// Escritura A la portada
//--------------------------------------------------------------

function bd_escribir_portada($seccion, $ref) {
	$vinculo = bd_abrir();
	$consulta = "INSERT INTO `portada` (`ref`, `seccion`, `ref_s`)
					 VALUES ('', '$seccion', '$ref')";
	mysql_query( $consulta );
	mysql_close( $vinculo );
}

//------------------- db_escribir_blog(); -------------------
// Escritura del blog
//--------------------------------------------------------------

function bd_escribir_blog($titulo ,$cont1 ,$cont2) {

	$vinculo = bd_abrir();
	$consulta = "INSERT INTO `blog` (`ref`, `fecha`, `titulo`, `blog`, `post`, `comentarios`)
			 		VALUES ('', NOW(), '$titulo', '$cont1', '$cont2', '0');";
	mysql_query( $consulta );
	mysql_close( $vinculo );

//	if ($portada == 1)
//		db_escribir_portada('blog', bd_comprobar_ultimo('blog'));
}


//------------------- db_escribir_comentario(); -------------------
// Escritura un comentario
//--------------------------------------------------------------
function bd_escribir_comentario ($datos) { 

	$vinculo = bd_abrir();
	$consulta = "
				INSERT INTO `comentarios` ( `ref` ,
											`fecha` ,
				 							`email` , 
											`seccion` , 
											`ref_seccion` , 
											`contenido` )
				VALUES ('', 
						NOW( ) , 
						'".$datos['email']."', 
						'".$datos['seccion']."', 
						'".$datos['ref']."', 
						'".$datos['content']."');	";

	mysql_query( $consulta );
	mysql_close( $vinculo );
}

//---------- db_comentario_activar($seccion, $ref); ------------
// Indica en un log que hay comentarios
//--------------------------------------------------------------
function bd_comentario_activar($seccion, $ref) { 
	$vinculo = bd_abrir();
	$consulta = "
				UPDATE `$seccion`
				 SET `comentarios` = '1'
				 WHERE `ref` = '$ref'
			";
	mysql_query( $consulta );
	mysql_close( $vinculo );
}



//==============================================================
//	Gestion de borrado y reescritura
//==============================================================


//------------------- db_borrar_comentario($ref); -------------------
// Borra un comentario
//--------------------------------------------------------------
function db_borrar_comentario($ref) { //<--Escribir esto
}





?>
