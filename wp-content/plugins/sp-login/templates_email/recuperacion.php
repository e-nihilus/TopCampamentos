<?php

	$remplace = array(
		"{{url}}" 			=> get_option( "siteurl" ),
		"{{logo}}" 			=> SPUSER_URL . "img/topcampamentos.png",
		"{{title}}" 		=> get_option( "blogname" ),
		"{{titulo}}" 		=> "",
		"{{contenido}}" 	=> "Hola $_data->Nombre,<br><br>¿Has solicitado la recuperación de contraseña de la plataforma TOP Campamentos?, Sí es así por favor haga click <a href='$_data->Link' style='color:#003C80;text-decoration:underline;'>aquí</a><br><br>Si por el contrario no solicitó ningún cambio de contraseña, por favor ignore el presente mensaje.<br><br>Para cualquier duda puede ponerse en contacto con nosotros en el correo <a href='mailto:info@topcampamentos.com'>info@topcampamentos.com</a> o al teléfono +34 646 022 818<br><br>El equipo de TOP Campamentos<br><br><b>NOTA:</b>Si tienes problema con el enlace por favor copia y pega el siguiente enlace: $_data->Link en tu navegador",
		"{{coping}}" 		=> "Copyright © ".date("Y")." TOP CAMPAMENTOS - VALLE ABEDULES S.L.",
		"{{info_footer}}" 	=> "",
		"{{address}}" 		=> "El contenido de este correo electrónico es confidencial, es parte de una conversación entre $_data->Nombre y TOP Campamentos. Está estrictamente prohibido compartir cualquier parte de este mensaje con terceros, sin el consentimiento escrito del remitente. Si ha recibido este mensaje por error, por favor responda a este mensaje y prosiga con su eliminación, para que podamos asegurarnos de que este error no ocurra otra vez en el futuro.",
		"{{site}}" 			=> "www.topcampamentos.com",
	);

	$_config = array(
		"Nombre"		=> "[TOP Campamentos] - Recuperación de cuenta",
		"Correo"		=> "info@topcampamentos.com"
	);
