<?php

	$remplace = array(
		"{{url}}" 			=> get_option( "siteurl" ),
		"{{logo}}" 			=> SPUSER_URL . "img/topcampamentos.png",
		"{{title}}" 		=> get_option( "blogname" ),
		"{{titulo}}" 		=> "",
		"{{contenido}}" 	=> "Hola $_data->Nombre,<br><br>¡Enhorabuena! Tu cuenta ha sido aprobada y está lista para que comiences a reservar campamentos.<br><br>Lo primero válidate con tu usuario y contraseña.<br><br>Usuario: $_data->User<br>Password: La introducida en el registro, Sí no la recuerda haga clic <a href='$_data->url_recovery'>aquí.",
		"{{coping}}" 		=> "Copyright © ".date("Y")." TOP CAMPAMENTOS - VALLE ABEDULES S.L.",
		"{{info_footer}}" 	=> "",
		"{{address}}" 		=> "El contenido de este correo electrónico es confidencial, es parte de una conversación entre $_data->Nombre y TOP Campamentos. Está estrictamente prohibido compartir cualquier parte de este mensaje con terceros, sin el consentimiento escrito del remitente. Si ha recibido este mensaje por error, por favor responda a este mensaje y prosiga con su eliminación, para que podamos asegurarnos de que este error no ocurra otra vez en el futuro.",
		"{{site}}" 			=> "www.topcampamentos.com",
	);

	$_config = array(
		"Nombre"		=> "[TOP Campamentos] - Gestión de cuentas",
		"Correo"		=> "info@topcampamentos.com"
	);
