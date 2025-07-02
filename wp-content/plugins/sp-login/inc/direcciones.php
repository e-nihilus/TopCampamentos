<div class="spuser_modal" id="spuser_back" style="display: none;">
	<div class="spuser_cont" id="spuser_register_dir">
		<div class="spuser_head">
			<span class="spuser_titulo"><?=__("Nueva Dirección", "spuser");?></span>
			<span class="spuser_close spuser_closem">X</span>
		</div>
		<div class="spuser_body">
			<form id="spuser_register_dir_data">
				<div class="spuser_item">
					<input class="spuser_input" type="text" name="nombre" id="spuser_d2" required />
					<label for="spuser_d2"><?=__("Nombre", "spuser");?><span>*</span></label>
				</div>
				<div class="spuser_item">
					<input class="spuser_input" type="text" maxlength="50" name="direccion" id="spuser_d3" required />
					<label for="spuser_d3"><?=__("Dirección", "spuser");?><span>*</span></label>
				</div>
				<div class="spuser_item_cont">
					<div class="spuser_item spuser_item_33">
						<input class="spuser_input" type="text" name="poblacion" id="spuser_d4" required />
						<label for="spuser_d4"><?=__("Población", "spuser");?><span>*</span></label>
					</div>
					<div class="spuser_item spuser_item_33">
						<select class="spuser_input active" type="text" name="provincia" id="spuser_d5"  required>
							<option>Albacete</option>
							<option>Alicante/Alacant</option>
							<option>Almería</option>
							<option>Araba/Álava</option>
							<option>Asturias</option>
							<option>Ávila</option>
							<option>Badajoz</option>
							<option>Balears, Illes</option>
							<option>Barcelona</option>
							<option>Bizkaia</option>
							<option>Burgos</option>
							<option>Cáceres</option>
							<option>Cádiz</option>
							<option>Cantabria</option>
							<option>Castellón/Castelló</option>
							<option>Ceuta</option>
							<option>Ciudad Real</option>
							<option>Córdoba</option>
							<option>Coruña, A</option>
							<option>Cuenca</option>
							<option>Gipuzkoa</option>
							<option>Girona</option>
							<option>Granada</option>
							<option>Guadalajara</option>
							<option>Huelva</option>
							<option>Huesca</option>
							<option>Jaén</option>
							<option>León</option>
							<option>Lleida</option>
							<option>Lugo</option>
							<option>Madrid</option>
							<option>Málaga</option>
							<option>Melilla</option>
							<option>Murcia</option>
							<option>Navarra</option>
							<option>Ourense</option>
							<option>Palencia</option>
							<option>Palmas, Las</option>
							<option>Pontevedra</option>
							<option>Rioja, La</option>
							<option>Salamanca</option>
							<option>Santa Cruz de Tenerife</option>
							<option>Segovia</option>
							<option>Sevilla</option>
							<option>Soria</option>
							<option>Tarragona</option>
							<option>Teruel</option>
							<option>Toledo</option>
							<option>Valencia/València</option>
							<option>Valladolid</option>
							<option>Zamora</option>
							<option>Zaragoza</option>

						</select>
						<label for="spuser_d5"><?=__("Provincia", "spuser");?><span>*</span></label>
					</div>
					<div class="spuser_item spuser_item_33">
						<input class="spuser_input" type="text" name="zip" id="spuser_d6"  required/>
						<label for="spuser_d6"><?=__("Código postal", "spuser");?><span>*</span></label>
					</div>
				</div>
			</form>
		</div>
		<div class="spuser_footer">
			<button id="spuser_register_new_dir" class="spuser_btn"><?=__("Crear", "spuser");?></button>
		</div>
	</div>
</div>