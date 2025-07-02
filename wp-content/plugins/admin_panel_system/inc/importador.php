<?php 

	if(isset($_POST['file'])){
		if(isset($_FILES['archivo']) && $_FILES['archivo']['error'] == '0' && $_FILES['archivo']['type'] == 'application/vnd.ms-excel'){
			$pst = $_FILES['archivo']['tmp_name'];
			if($gestor = fopen($pst, "r")){
				global $wpdb;
				$inv_productos = $wpdb->prefix . "inv_productos";
				$line = -1;
				$sucess = 0;
				$errores = 0;
				$_user = [];
				$_mensaje = [];
				while (($dataproduc = fgetcsv($gestor, 10240, ";")) !== FALSE) {
					$line++; if($line == 0) continue;

					$_u = isset($_user[$dataproduc[10]])?$_user[$dataproduc[10]]:false;
					if(!$_u){
						$_nu = get_user_by("ID", $dataproduc[10]);
						if($_nu){
							$_u = $_user[$dataproduc[10]] = $_nu->ID;
						}else{
							$errores++;
							$_mensaje[$dataproduc[10]] = "El usuario $dataproduc[10] no existe";
						}
					}
					if($_u){
						$_data = [
							"sku" 			=> $dataproduc[0],
							"coste"			=> str_replace(",", ".", $dataproduc[1]),
							"pdc_siva"		=> str_replace(",", ".", $dataproduc[3]),
							"iva"			=> str_replace(",", ".", $dataproduc[5]),
							"pdc_civa"		=> str_replace(",", ".", $dataproduc[2]),
							"preparacion"	=> str_replace(",", ".", $dataproduc[6]),
							"transporte"	=> str_replace(",", ".", $dataproduc[7]),
							"otros"			=> str_replace(",", ".", $dataproduc[8]),
							"beneficio"		=> $dataproduc[9],
							"user"			=> $_u
						];
						if($_ID = $wpdb->get_var("SELECT id FROM $inv_productos WHERE sku = '$dataproduc[0]'")){
							if($wpdb->update($inv_productos, $_data, ["id" => $_ID]) === false){
								$errores++;
								$_mensaje[$dataproduc[0]] = "Error al actualizar el sku $dataproduc[0]";
							}
						}else{
							if($wpdb->insert($inv_productos, $_data) === false){
								$errores++;
								$_mensaje[$dataproduc[0]] = "Error al crear el sku $dataproduc[0]";
							}
						}
					}
				}
				if(count($_mensaje)){
					echo "<div class='notice notice-warning is-dismissible'>
						<p>Archivo procesado con errores</p>
						<p>Lineas Procesadas: $line, Existosas: ".($line-$errores).", errores: $errores</p>
						<p>".implode("<br>", $_mensaje)."</p>
					</div>";
				}else{
					echo "<div class='notice notice-success is-dismissible'><p>Archivo procesado con éxito</p></div>";
				}
				
			}else{
				echo "<div class='notice notice-error is-dismissible'><p>Error abrir el archivo</p></div>";
			}
		}else{
			echo "<div class='notice notice-error is-dismissible'><p>El archivo seleccionado no es valido</p></div>";
		}
	}

	$data = [
				"id" 			=> '',
				"sku" 			=> '',
				"coste"			=> '',
				"pdc_siva"		=> '',
				"iva"			=> '',
				"pdc_civa"		=> '',
				"preparacion"	=> '',
				"transporte"	=> '',
				"otros"			=> '',
				"beneficio"		=> '',
				"user"			=> '',
				"data_extra"	=> ''
			];

?>


<div class="wrap">
	<div id="icon-users" class="icon32"></div>
	<h1 class="wp-heading-inline">Importador de productos</h1>
	<form action="#" method="post" enctype="multipart/form-data">
		<table>
			<tbody>
				<tr>
					<th>Selecciones el archivo (.csv)</th>
					<td><input type="file" name="archivo" accept=".csv"></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" name="file" class="button button-primary button-large" value="Procesar">
	</form>
</div>