// const $ = jQuery;
const loading = function(text){var el = $("#spuser_loading");if(!el.length){el = $('<div class="spuser_modal" id="spuser_loading"><div class="spuser_modal_load"><p class="spuser_modal_load_title"><span id="load-msg">Cargando</span><span>.</span><span>.</span><span>.</span></p></div></div>')};el.find("#load-msg").text(text);$("body").append(el);el.fadeIn();}
const loading_end = function(time = 0){var el = $("#spuser_loading");if(el.length > 0){setTimeout(function(){el.fadeOut();setTimeout(function() { el.remove();}, 500);}, time);}}
const spuser_open = function(el){$("#spuser_back").fadeIn(); $("#spuser_back .spuser_cont:not("+el+")").removeClass("active"); $(el).show(); setTimeout(function(){$("#spuser_back .spuser_cont:not("+el+")").hide();$(el).addClass("active");},300);}
const isEmail = function(email) { var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/; return regex.test(email); }
$.fn.serializeObject = function() {var o = {};var a = this.serializeArray();$.each(a, function() {if (o[this.name]) {if (!o[this.name].push) {o[this.name] = [o[this.name]];}o[this.name].push(this.value || '');} else {o[this.name] = this.value || '';}});return o;};

$(document).ready(function(){

	// --- portal camps ---

	$(".spuser_cont").hide();
	$(".spuser_cont.register").show();

	let url = window.location.href;
	if(url.endsWith('recovery')){
		console.log('ksjdjsd')
		$(".spuser_cont.register").hide();
		$(".spuser_cont.recovery").show();
	}

	function back_content_portal_TOP(){
		if($(window).width() < 1025){
			let backprovisional = window.location.protocol + "//" + window.location.hostname + '/wp-content/uploads/2023/03/back-portal-provisional.jpg';
			$(".content_portal_TOP").css({backgroundImage: `url(${backprovisional})`, backgroundSize: 'cover', backgroundPosition: 'center', backgroundRepeat: 'no-repeat'})
		}
	}

	back_content_portal_TOP()

	$(window).resize(function(){
		back_content_portal_TOP()
	})
	
	

	function current_tab_TOP(){
		let currentTabRL = $('.spuser_cont:visible').attr('class');
		if(currentTabRL.includes('register')){
			$(".login-register-tabs h4").removeClass("current_tab");
			$(".login-register-tabs h4:first-child").addClass("current_tab");
		}else if(currentTabRL.includes('login')){
			$(".login-register-tabs h4").removeClass("current_tab");
			$(".login-register-tabs h4:last-child").addClass("current_tab");
		}else{
			$(".login-register-tabs h4").removeClass("current_tab");
		}
	}

	current_tab_TOP()

	$("[tab]").click(function(e){
		e.preventDefault();
		let newTab = $(this).attr("tab");
		$(".spuser_cont").hide();
		$(".spuser_cont."+newTab).show();
		current_tab_TOP()
	})

	if($("#spuser_reset").length){
		history.pushState(null, "", window.location.href.split('?')[0]);
		$(".spuser_cont#spuser_register").hide();
		$(".login-register-tabs h4").removeClass("current_tab");
		spuser_open("#spuser_reset");
	}

	$(".spuser_input").on("input", function(e){
		e.preventDefault();
		if($(this).val() != ""){
			$(this).addClass("active").removeClass("invalido");
		}else{
			$(this).removeClass("active");
		}
	})

	if(ajax.open == 1) spuser_open("#spuser_restore");
	if(ajax.open == 2) spuser_open("#spuser_login");
	if(ajax.login == 1) jQuery("[tab='login']").click();
	

	$("#spuser_login_send").click(function(e){
		if($("#spuser_name").val().length && $("#spuser_pass").val().length ){
			var _dts = {};
			_dts.us = $("#spuser_name").val();
			_dts.ps = $("#spuser_pass").val();
			loading("Validando");
			grecaptcha.ready(function() { 
				grecaptcha.execute(ajax.key, {action: 'spuser_valid'}).then(
					function(spuser_captcha) { 
						$.ajax({
				           	type : "POST",
				           	url : ajax.url,
				           	dataType: 'json',
				           	data : {
				           		action: 'spuser',
				                unik: ajax.nonce,
				                type: 1,
				                token: spuser_captcha,
				                dts: _dts
				           	},
				           	error: function(rsp){
				           		alert("Sistema no disponible intente más tarde!");
				           		loading_end();
				           	},
				           	success: function(rsp) {
				           		if(rsp.r){
				           			window.location.href = rsp.url;
				           		}else{
				           			loading_end();
				           			alert(rsp.m);
				           		}
							}
						})
					}
				);
			});
		}else{
			alert("Por favor escriba su usuario y contraseña para continuar");
		}
	})

	$("#spuser_restore_send").click(function(e){
		if($("#spuser_mail").val().length && isEmail($("#spuser_mail").val())){
			loading("Recuperando");
			grecaptcha.ready(function() { 
				grecaptcha.execute(ajax.key, {action: 'spuser_valid'}).then(
					function(spuser_captcha) { 
						$.ajax({
				           	type : "POST",
				           	url : ajax.url,
				           	dataType: 'json',
				           	data : {
				           		action: 'spuser',
				                unik: ajax.nonce,
				                type: 2,
				                token: spuser_captcha,
				                mail_recovery: $("#spuser_mail").val()
				           	},
				           	complete: function(){
				           		//spuser_captcha_f();
				           	},
				           	error: function(rsp){
				           		alert("Sistema no disponible intente más tarde!");
				           		loading_end();
				           	},
				           	success: function(rsp) {
				           		loading_end();
				           		if(rsp.r) $("#spuser_back").fadeOut();
				           		alert(rsp.m, rsp.r);
							}
						})
					}
				);
			});
		}else{
			alert("Por favor escriba un correo electrónico para continuar");
		}
	})

	$("#spuser_reset_send").click(function(e){
		if($("#spuser_pass_r1").val().length > 5 && $("#spuser_pass_r2").val().length > 5 && $("#spuser_pass_r2").val() == $("#spuser_pass_r1").val()){
			loading("Solicitando");
			grecaptcha.ready(function() { 
				grecaptcha.execute(ajax.key, {action: 'spuser_valid'}).then(
					function(spuser_captcha) {
						$.ajax({
				           	type : "POST",
				           	url : ajax.url,
				           	dataType: 'json',
				           	data : {
				           		action: 'spuser',
				                unik: ajax.nonce,
				                type: 3,
				                token: spuser_captcha,
				                key: $("#spuser_key").val(),
				                new_pass: $("#spuser_pass_r1").val()
				           	},
				           	complete: function(){
				           		//spuser_captcha_f();
				           	},
				           	error: function(rsp){
				           		alert("Sistema no disponible intente más tarde!");
				           		loading_end();
				           	},
				           	success: function(rsp) {
				           		loading_end();
				           		alert(rsp.m, rsp.r);
				           		if(rsp.r) {
									$(".spuser_cont").hide();
									spuser_open("#spuser_login");
									current_tab_TOP()
								}
							}
						})
					}
				);
			});

		}else{
			alert("Por favor escriba una contraseña igual en ambos campos con mínimo 6 caracteres");
		}
	})

	$("#spuser_register_send").click(function(e){
		var _dts = $("#spuser_register_data").serializeObject();
		if(_dts.cif.length && _dts.nombre_comercial.length && _dts.nombre_fiscal.length && _dts.direccion.length && _dts.provincia.length && _dts.zip.length && _dts.responsable.length && _dts.movil.length && _dts.correo.length && _dts.pass.length){
			if($("#spuser_d10").val().length > 5){
				if($("#spuser_d10").val() == $("#spuser_d11").val()){
					if(isEmail(_dts.correo)){
						if($("#legal_check").prop("checked")){
							loading("Enviando");
							grecaptcha.ready(function() { 
								grecaptcha.execute(ajax.key, {action: 'spuser_valid'}).then(
									function(spuser_captcha) {
										$.ajax({
											type : "POST",
											url : ajax.url,
											dataType: 'json',
											data : {
												action: 'spuser',
												unik: ajax.nonce,
												type: 4,
												token: spuser_captcha,
												dts: _dts
											},
											complete: function(){
												//spuser_captcha_f();
											},
											error: function(rsp){
												alert("Sistema no disponible intente más tarde!");
												loading_end();
											},
											success: function(rsp) {
												loading_end();
												alert(rsp.m, rsp.r);
												if(rsp.r){
													$("#spuser_back").fadeOut();
													$('#spuser_register_data').trigger("reset");
													$('#spuser_register_data input').removeClass("active");
													setTimeout(() => {
														window.location.href = rsp.rd;
													}, 1500);
												} 
											}
										})
									}
								);
							});
						}else{
							alert("Seleccione la opción para aceptar las políticas de privacidad y los términos y condiciones")
						}
					}else{
						alert("El correo introducido no es correcto");
					}
				}else{
					alert("Las contraseñas no coinciden");
				}
			}else{
				alert("Se requiere mínimo 6 caracteres para establecer una contraseña");
			}
		}else{
			$("#spuser_register_data").find("input[required]").each(function(k,v){
				if($(v).val() == "") $(v).addClass("invalido"); 
			})
			if(!$("#spuser_register_data").find("select[required]").val()){
				$("#spuser_register_data select[required]").addClass("invalido"); 
			}
			alert("Por favor rellene todos los campos marcados con *");
		}
	})
})