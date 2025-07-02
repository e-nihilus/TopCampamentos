<div class="spuser_cont login" id="spuser_login">
	<div class="spuser_body login">
		<div class="spuser_item">
			<input class="spuser_input" type="text" name="_login" id="spuser_name" placeholder="CIF / Correo"/>
		</div>
		<div class="spuser_item">
			<input class="spuser_input" type="password" name="_pass" id="spuser_pass" placeholder="Contraseña"/>
		</div>
		<div class="spuser_link">
			<a href="#" class="spuser_open_register" tab="register"><?=__("Registrarte", "spuser");?></a>
			<a href="#" class="spuser_open_restore" tab="recovery"><?=__("Recuperar contraseña", "spuser");?></a>
		</div>
	</div>
	<div class="spuser_footer login">
		<button id="spuser_login_send" class="spuser_btn"><?=__("Ingresar", "spuser");?></button>
	</div>
</div>