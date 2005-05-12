<?
			include("functions/includes.php");
//			include("functions/interface.php");
			if (!isset($_GET['page']))
				$pagina = 0;
			else
				$pagina = $_GET['page'];	


			interface_portada("portada",  portada_lista_imprimir( $pagina) );

?>

