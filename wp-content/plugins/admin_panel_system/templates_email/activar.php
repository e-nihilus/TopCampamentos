<?php

	$remplace = array(
		"{{url}}" 			=> get_option( "siteurl" ),
		"{{logo}}" 			=> 'https://marktmaat.com/wp-content/uploads/2020/05/logo-b-1.png',
		"{{title}}" 		=> get_option( "blogname" ),
		"{{titulo}}" 		=> "Correo de activación",
		"{{contenido}}" 	=> "Hola $_data->Nombre,<br><br>Nos alegra que te una a nuestra familia para activar tu cuenta haz click <a href='$_data->Link' target='_blank'>aquí</a> para continuar<br><br><b>NOTA:</b>Si tienes problema con el enlace por favor copia y pegua el siguiente enlace: $_data->Link",
		"{{coping}}" 		=> "Copyright © 2020 MarktMaat",
		"{{info_footer}}" 	=> "MarkMaat",
		"{{address}}" 		=> "El contenido de este correo electrónico es confidencial, es parte de una conversación entre $_data->Nombre y beguerrilla. Está estrictamente prohibido compartir cualquier parte de este mensaje con terceros, sin el consentimiento escrito del remitente. Si ha recibido este mensaje por error, por favor responda a este mensaje y prosiga con su eliminación, para que podamos asegurarnos de que este error no ocurra otra vez en el futuro.",
		"{{site}}" 			=> "www.marktmaat.com",
	);

	$_config = array(
		"Nombre"		=> "[MarktMaat] - Activación de cuenta",
		"Correo"		=> "no-reply@marktmaat.com"
	);