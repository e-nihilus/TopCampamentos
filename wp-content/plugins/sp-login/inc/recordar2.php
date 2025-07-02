<div class="spuser_cont recovery2" id="spuser_reset">
	<div class="spuser_head recovery">
		<span class="spuser_titulo"><?=__("Elige una nueva contraseña", "spuser");?></span>
	</div>
	<div class="spuser_body recovery2">
		<input type="hidden" id="spuser_key" value="<?=$_GET['spuser_recovery']?>">
		<div class="spuser_item">
			<input class="spuser_input" type="password" id="spuser_pass_r1" placeholder="Nueva contraseña"/>
		</div>
		<div class="spuser_item">
			<input class="spuser_input" type="password" id="spuser_pass_r2" placeholder="Confirmar contraseña"/>
		</div>
	</div>
	<div class="spuser_footer recovery2">
		<button id="spuser_reset_send" class="spuser_btn"><?=__("Enviar", "spuser");?></button>
	</div>
</div>