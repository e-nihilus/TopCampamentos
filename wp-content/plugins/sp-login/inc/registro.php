<div class="spuser_cont register" id="spuser_register">

	<div class="spuser_body">

		<form id="spuser_register_data">

			<div class="spuser_item">

				<input class="spuser_input" type="text" name="cif" id="spuser_d0" required placeholder="CIF*" />

			</div>

			<div class="spuser_item_cont">

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="text" name="nombre_comercial" id="spuser_d1" required placeholder="Nombre comercial*" />

				</div>

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="text" name="nombre_fiscal" id="spuser_d2"  required placeholder="Nombre fiscal*"/>

				</div>

			</div>

			<div class="spuser_item">

				<input class="spuser_input" type="text" name="direccion" id="spuser_d3" required placeholder="Dirección*" />

			</div>

			<div class="spuser_item_cont">

				<div class="spuser_item spuser_item_33">

					<input class="spuser_input" type="text" name="poblacion" id="spuser_d4" placeholder="Población" />

				</div>

				<div class="spuser_item spuser_item_33">

					<select class="spuser_input active" type="text" name="provincia" id="spuser_d5"  required>
						<option selected disabled>Región*</option>
						<option>Andalucía</option>
						<option>Aragón</option>
						<option>Asturias</option>
						<option>Islas Baleares</option>
						<option>Canarias</option>
						<option>Cantabria</option>
						<option>Castilla-La Mancha</option>
						<option>Castilla y León</option>
						<option>Cataluña</option>
						<option>Comunidad Valenciana</option>
						<option>Extremadura</option>
						<option>Galicia</option>
						<option>La Rioja</option>
						<option>Madrid</option>
						<option>Murcia</option>
						<option>Navarra</option>
						<option>País Vasco</option>
					</select>

				</div>

				<div class="spuser_item spuser_item_33">

					<input class="spuser_input" type="text" name="zip" id="spuser_d12" placeholder="Código postal"/>

				</div>

			</div>

			<div class="spuser_item_cont">

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="text" name="responsable" id="spuser_d6" required placeholder="Responsable*" />

				</div>

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="text" name="telefono" id="spuser_d7" placeholder="Teléfono" />

				</div>

			</div>

			<div class="spuser_item_cont">

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="text" name="movil" id="spuser_d8" required placeholder="Móvil*" />

				</div>

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="text" name="correo" id="spuser_d9" required placeholder="Correo electrónico*" />

				</div>

			</div>

			<div class="spuser_item_cont">

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="password" name="pass" id="spuser_d10" required placeholder="Contraseña*" />

				</div>

				<div class="spuser_item spuser_item_50">

					<input class="spuser_input" type="password" id="spuser_d11" required placeholder="Repite contraseña*" />

				</div>

			</div>

		</form>

		<div class="spuser_link">

			<label for="legal_check">

				<input type="checkbox" required id="legal_check">

				<span>He leido y acepto las <a href="<?= home_url('/politica-de-privacidad/') ?>" target="_blank" title="Enlace a la página de políticas de privacidad">Políticas de privacidad</a> y los <a href="<?= home_url('/aviso-legal/') ?>" target="_blank" title="Enlace a la página de términos y condiciones">Términos y condiciones</a></span>

			</label>

		</div>

	</div>

	<div class="spuser_footer">

		<button id="spuser_register_send" class="spuser_btn"><?=__("Confirmar registro", "spuser");?></button>

	</div>

</div>