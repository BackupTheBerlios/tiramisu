<?PHP 



// Filtro para la salida de datos:
// Filtra un texto pasando los parametros a html
function filtro_salida($texto) {
	$sw2 = $sw = 0;
	$salida = '';
	$param = '';
	$atriv = '';

	for($cont = 0; $texto[$cont] != NULL ; $cont++) {

		if( $texto[$cont] == '[')
			$sw = 1;
		else {
			if( $texto[$cont] == ']' && $sw == 1){
				$sw = 0;
				$salida = $salida.filtro_selector($param, $atriv);
			}
			else {
				if($sw == 1) {
					if($texto[$cont] == '=')
						$sw2 = 1;
					else {
						if($sw2 == 1  && $texto[$cont] != '' )
							$atriv = $atriv.$texto[$cont];
						else 
							$param = $param.$texto[$cont];
					}
				}
				else 
					$salida = filtro_filtrachar($texto[$cont], $salida);
			}
		}
	}

	return $salida;
}




function filtro_filtrachar($caracter, $salida) {
		if($caracter == "\n")
			$salida = $salida."<br>";
		else
		if($caracter == '<')
			$salida = $salida."&lt;";
		else
		if($caracter  == '>')
			$salida = $salida."&gt;";
/*		else
		if($caracter  == 'ñ')
			$salida = $salida."&ntilde;";
		else
		if($caracter  == 'á')
			$salida = $salida."&aacute;";
		else
		if($caracter  == 'é')
			$salida = $salida."&eacute;";
		else
		if($caracter  == 'í')
			$salida = $salida."&iacute;";
		else
		if($caracter  == 'ó')
			$salida = $salida."&oacute;";
		else
		if($caracter  == 'ú')
			$salida = $salida."&uacute;"; */
		else 
			$salida = $salida.$caracter;

		return $salida;
}




//-Entra el tipo de parametro y su clave
//-Sale el filtro aplicado 
function filtro_selector($param, $atriv) {

	if($param == "link") 
		return " http://<a href='http://".$atriv."'>".$atriv."</a>";
	else
		return " PARÃMETRO ERRONEO ";
}


function filtro_fecha($fecha) {
		$fch = explode("-", $fecha);
		
		return $fch[2]."-".$fch[1]."-".$fch[0];
}
?>
