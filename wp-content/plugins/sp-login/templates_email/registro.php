<?php

	$remplace = array(
		"{{url}}" 			=> get_option( "siteurl" ),
		"{{logo}}" 			=> SPUSER_URL . "img/topcampamentos.png",
		"{{title}}" 		=> get_option( "blogname" ),
		"{{titulo}}" 		=> "",
		"{{contenido}}" 	=> "Estimado $_data->Nombre,
								<br>
								<br>Se ha registrado un nuevo usuario, estará pendiente de su aprobación, haga click <a target='_blank' href='$_data->url_damin'>aquí</a> para dirigirle a página de administración.
								<br>
								<br>Datos:
								<br>
								<ul>
								<li>Nombre Responsable: $_data->responsable</li>
								<li>Teléfono: $_data->movil / $_data->telefono</li>
								<li>Empresa: $_data->empresa</li>
								<li>Región: $_data->povincia</li>
								<li>Correo: $_data->correo</li>
								</ul>
								<br>Atentamente, sistema TOP Campamentos",
		"{{coping}}" 		=> "Copyright © ".date("Y")."  TOP CAMPAMENTOS - VALLE ABEDULES S.L.",
		"{{info_footer}}" 	=> "",
		"{{address}}" 		=> "El contenido de este correo electrónico es confidencial, es parte de una conversación entre $_data->Nombre y TOP Campamentos. Está estrictamente prohibido compartir cualquier parte de este mensaje con terceros, sin el consentimiento escrito del remitente. Si ha recibido este mensaje por error, por favor responda a este mensaje y prosiga con su eliminación, para que podamos asegurarnos de que este error no ocurra otra vez en el futuro.",
		"{{site}}" 			=> "www.topcampamentos.com",
	);

	$_config = array(
		"Nombre"		=> "[TOP Campamentos] - Gestión de cuentas",
		"Correo"		=> "info@topcampamentos.com"
	);
