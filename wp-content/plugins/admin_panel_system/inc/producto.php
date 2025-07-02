<?php
	global $wpdb;
	$inv_productos = $wpdb->prefix . "inv_productos";
	$_mesaje = [];

	if(isset($_POST['id'])){

		$data = $_POST;
						
  		///Verifica sku
  		$exist_sku = $wpdb->get_var( "SELECT id FROM $inv_productos WHERE sku = '$data[sku]';" );
  		if($exist_sku &&  $exist_sku != $data['id']) $_mesaje[] = "Ya existe una producto con este sku";

  		///verificar si existe beneficio
  		$_bene = get_user_meta($data['user'], 'benefico_mm', true);
  		if(!$data['beneficio'] && !$_bene) $_mesaje[] = "Debe indicar un beneficio para este usuario";
  		if(!$data['beneficio'] && $_bene) $data['beneficio'] = $_bene;
  		if($data['beneficio'] && !$_bene) update_user_meta($data['user'], 'benefico_mm', $data['beneficio']);

  		///Crear producto
  		if(!count($_mesaje)){
  			if($wpdb->replace($inv_productos, $data)){
				echo "<div class='notice notice-success is-dismissible'><p>Producto actualizado</p></div>";
				unset($data);
				$_GET['edit'] = $wpdb->insert_id;
			}else{
				$_mesaje[] = "Error al guardar el producto en la base de datos";
			}
  		}
	}

	if(!isset($data)){
		if(isset($_GET['edit'])){
	     	$data = $wpdb->get_row( "SELECT * FROM $inv_productos WHERE id = $_GET[edit];", ARRAY_A );
	     	if(!$data) wp_die("Producto Invalido");	
		}else{
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
		}
	}

	///css
	wp_enqueue_style( 'extras-admin', ADPNSY_URL . "/css/extras.css", [],  filemtime(ADPNSY_PATH . '/css/extras.css'));

	///js
	wp_enqueue_script( 'extras-admin', ADPNSY_URL . "/js/extras.js", array( 'jquery'),  filemtime(ADPNSY_PATH . '/js/extras.js'));

?>

<?php if(count($_mesaje)){
	foreach ($_mesaje as $mesaje) {
		echo "<div class='notice notice-error is-dismissible'><p>$mesaje</p></div>";
	}
} ?>

<div class="wrap">
	<div id="icon-users" class="icon32"></div>
	<h1 class="wp-heading-inline"><?=isset($_GET['edit'])?'Editar':'Crear';?> producto</h1>
	<form method="post" action="#" id='categoria'>
		<input type="hidden" name="id" value="<?=$data['id'];?>" />
		<div class="adpnsy_content" id='extrabox'>
			<div class="adpnsy_header">Característica</div>
			<table class="adpnsy_table">
				<tbody>
					<tr>
						<th>Sku</th>
						<td><input type="text" required="required" maxlength="255" name='sku'  value='<?=$data['sku']?>' <?=isset($_GET['edit'])?'readonly="readonly"':'';?> /></td>
					</tr>
					<tr>
						<th>Inversión</th>
						<td><input type="number" required="required" step="0.01" min="0.01" readonly name='coste' value='<?=$data['coste']?>' /></td>
					</tr>
					<tr>
						<th>Precio de compra sin IVA</th>
						<td><input type="number" required="required" step="0.01" min="0.01" name='pdc_siva' value='<?=$data['pdc_siva']?>' /></td>
					</tr>
					<tr>
						<th>IVA de compra</th>
						<td><input type="number" required="required" step="1" min="0" name='iva' value='<?=$data['iva']?>' /></td>
					</tr>
					<tr>
						<th>Precio de compra con IVA</th>
						<td><input type="number" required="required" step="0.01" min="0.01" name='pdc_civa' value='<?=$data['pdc_civa']?>' /></td>
					</tr>
					<tr>
						<th>Coste de preparación</th>
						<td><input type="number" required="required" step="0.01" min="0" name='preparacion' value='<?=$data['preparacion']?>' /></td>
					</tr>
					<tr>
						<th>Coste de trasporte</th>
						<td><input type="number" required="required" step="0.01" min="0" name='transporte' value='<?=$data['transporte']?>' /></td>
					</tr>
					<tr>
						<th>Otros coste</th>
						<td><input type="number" required="required" step="0.01" min="0" name='otros' value='<?=$data['otros']?>' /></td>
					</tr>
					<tr>
						<th>Beneficio</th>
						<td><span>%</span><input type="number" step="1" min="1" name='beneficio' value='<?=$data['beneficio']?>' /></td>
					</tr>
					<tr>
						<th>Inversor</th>
						<td>
							<?php $users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) ); ?>
							<select <?=isset($_GET['edit'])?'disabled="disabled"':'name="user"';?>>
								<?php foreach($users as $user){
									if($data["user"] == $user->ID){
										echo "<option selected value='$user->ID'>$user->display_name</option>";
									}else{
										echo "<option value='$user->ID'>$user->display_name</option>";
									}
								} ?>
							</select>
							<?=isset($_GET['edit'])?'<input type="hidden" name="user" value="'.$data["user"].'" />':'';?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- save -->
		<div class="adpnsy_content buttons-footer"> 
			<div>
				<div class="row">
					<div class="col-3"></div>
					<div class="col-9 text-right">
						<button class="button button-primary button-large"><span class="dashicons dashicons-yes"></span>Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
