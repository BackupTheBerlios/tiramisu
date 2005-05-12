<?

//include("bd.php");
//include("filtro.php");


//=============================================================
//			Lectura de portadas	
//=============================================================

//-----------------portada_paginador() -----------------------
//	Devuelve 1 o 0 si está en página o no
//function portada_paginador()


//---------------- portada_blog( referencia ) ----------------- 
function portada_blog($ref) {

	$blog = bd_leer_blog($ref);
	if($blog["titulo"] != NULL){

		$blog["blog"] =  filtro_salida( $blog["blog"] );
		$blog["fecha"] = filtro_fecha( $blog["fecha"]);
		$blog["tipo"] =  "blog"; //tipo
		return $blog;
	}

}
//function portada_estatico();
//function portada_album();


//-----------------portada_une( seccion, referencia); ---------
// En la portada principal, se dirige a una referencia en una
// determinada seccion 
//-------------------------------------------------------------

function portada_une( $seccion, $ref) {

	if( $seccion == "blog" )
		$tabla = portada_blog($ref);

	return $tabla;
}


//----------------------portada_lista_imprimir(); -------------------
// Imprime la lista de portada segun la pagina que se indique
// La primera pagina es 0	
//-------------------------------------------------------------
function portada_lista_imprimir($page) {
	
	$salida = NULL;
	$cont = 0;
	$ctot = 0;
	$n = 5; //numero de articulos por pagina	

	$art = $page*$n;

	$res = bd_portada_leer();
	foreach ($res as $cada_resultado) {
		if ($ctot >= $art && $ctot < ($art + $n)) {
			$salida[$cont] = portada_une( $cada_resultado[1], $cada_resultado[2] );
			$cont++;
		}
		$ctot++;
	}
	return($salida);
}


//====================================
// 		Lectura de BLOG
//=====================================


//----------------------blog_lista_imprimir(); -------------------
// Imprime la lista de la pagina del weblog 
//-------------------------------------------------------------
function blog_lista_imprimir($page) {
	$salida=NULL;
	$cont = 0;
	$ctot = 0;
	$n = 5; //numero de articulos por pagina	
	$art = $page*$n;

	$blog= bd_lista_seccion("blog");

	for($c=0; $c < $blog["numero"];$c++) {
		if ($ctot >= $art && $ctot < ($art + $n)) {
			$salida[$cont] = portada_blog($blog["refs"][$c]);
			$cont++;
		}
	$ctot++;
	}
	return $salida;
}
//-------------- blog_completo_imprimir( numero ) ------------
//	Imprime un blog de la lista de forma completa 
//------------------------------------------------------------
function blog_completo_imprimir( $ref) {
	$blog = bd_leer_blog($ref);

	$blog["blog"] = filtro_salida($blog["blog"]);
	$blog["post"]	= filtro_salida($blog["post"]);
	$blog["fecha"] = filtro_fecha($blog["fecha"]);

	return $blog;
}



//====================================
// 		Lectura de COMENTARIOS
//=====================================
function lectura_comentarios($seccion, $ref) {
	$lista = bd_lista_comentarios($seccion, $ref);
	$res=NULL;
	for($c=0; $c < $lista['numero']; $c++) {
		$res[$c] = bd_leer_comentario($lista['refs'][$c]);
		$res[$c]['fecha'] = filtro_fecha($res[$c]['fecha']);
		$res[$c]['email'] = filtro_salida($res[$c]['email']);
		$res[$c]['contenido'] = filtro_salida($res[$c]['contenido']);
	}		
	return $res;
}

?>

