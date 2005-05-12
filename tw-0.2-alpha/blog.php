<?
			include("functions/includes.php");
//			include("functions/interface.php");


			if (isset($_GET['blog'])){
					interface_blog_full( blog_completo_imprimir($_GET['blog']));
			}
			else {
				if (!isset($_GET['page']))
					$pagina = 0;
				else
					$pagina = $_GET['page'];	
				interface_portada( "blog", blog_lista_imprimir( $pagina) );
			}
?>
