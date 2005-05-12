<?
//---------escribir_blog -----------------------------
// ( $stat, $titulo, $cont1, $cont2, $portada{1,0});--
function escribir_blog( $titulo, $cont1, $cont2, $portada){

	bd_escribir_blog(  $titulo, $cont1,$cont2);
	if($portada == 1) {
		$ultimo = bd_comprobar_ultimo("blog");
		bd_escribir_portada("blog", $ultimo);
	}
}


//========================================
//		Escritura Comentarios
//========================================
function escritura_comentario($contenido) {
	bd_escribir_comentario($contenido);

	bd_comentario_activar($contenido['seccion'], $contenido['ref']);
}

?>
