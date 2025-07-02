<?php

	$remplace = array(
		"{{url}}" 			=> get_option( "siteurl" ),
		"{{logo}}" 			=> 'https://marktmaat.com/wp-content/uploads/2020/05/logo-b-1.png',
		"{{title}}" 		=> get_option( "blogname" ),
		"{{titulo}}" 		=> "",
		"{{contenido}}" 	=> "Hola $_data->Nombre,<br><br>¿Has solicitado la recuperación de contraseña de la plataforma MarktMaat?, Sí es así por favor haga click <a href='$_data->Link' style='color:#003C80;text-decoration:underline;'>aquí</a><br><br>Si por el contrario no solicitó ningún cambio de contraseña, por favor ignore el presente mensaje.<br><br>Para cualquier duda puede ponerse en contacto con nosotros en el correo <a href='mailto:info@marktmaat.com'>info@marktmaat.com</a><br><br>El equipo de MarktMaat<br><br><b>NOTA:</b>Si tienes problema con el enlace por favor copia y pegua el siguiente enlace: $_data->Link",
		"{{coping}}" 		=> "Copyright © 2020 MarktMaat",
		"{{info_footer}}" 	=> "Lorem ipsum",
		"{{address}}" 		=> "El contenido de este correo electrónico es confidencial, es parte de una conversación entre $_data->Nombre y beguerrilla. Está estrictamente prohibido compartir cualquier parte de este mensaje con terceros, sin el consentimiento escrito del remitente. Si ha recibido este mensaje por error, por favor responda a este mensaje y prosiga con su eliminación, para que podamos asegurarnos de que este error no ocurra otra vez en el futuro.",
		"{{site}}" 			=> "www.marktmaat.com",
	);

	$_config = array(
		"Nombre"		=> "[MarktMaat] - Recuperación de cuenta",
		"Correo"		=> "no-reply@marktmaat.com"
	);

