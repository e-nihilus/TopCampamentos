<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
	<head>
	    <?=$adpnsy->header($info)?>
	</head>
	<body class="horizontal-layout page-header-light horizontal-menu preload-transitions 1-column login-bg blank-page blank-page" data-open="click" data-menu="horizontal-menu" data-col="1-column">
	    <div class="row">
	        <div class="col s12">
	            <div class="container">
	                <div id="login-page" class="row">
	                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
	                        <form class="register-form" method="post" action="#" >
	                            <div class='error-login<?=$mensaje?" show":"";?>'><?=$mensaje;?></div>
	                            <div class="row">
	                                <div class="input-field col s12">
	                                    <?php if($info->lglogin_vn){echo'<img class="logo-login" src="'.$info->lglogin_vn.'" alt="Ideconsa">';}else{echo'<h5 class="ml-4">Ingresar</h5>';} ?>
	                                </div>
	                            </div>
	                            <div class="row margin">
	                                <div class="input-field col s12">
	                                    <i class="material-icons prefix pt-2">person_outline</i>
	                                    <input id="username" type="text" name='username'>
	                                    <label for="username" class="center-align">Nombre de usuario</label>
	                                </div>
	                            </div>
	                            <div class="row margin">
	                                <div class="input-field col s12">
	                                    <i class="material-icons prefix pt-2">email</i>
	                                    <input id="email" type="email" name='email'>
	                                    <label for="email" class="center-align">Correo de usuario</label>
	                                </div>
	                            </div>
	                            <div class="row margin">
	                                <div class="input-field col s12">
	                                    <i class="material-icons prefix pt-2">lock_outline</i>
	                                    <input id="password" type="password" name='password'>
	                                    <label for="password">Contraseña</label>
	                                </div>
	                            </div>
	                            <div class="row margin">
	                                <div class="input-field col s12">
	                                    <i class="material-icons prefix pt-2">lock_outline</i>
	                                    <input id="password2" type="password" name='password'>
	                                    <label for="password2">Repite contraseña</label>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="col s12 m12 l12 ml-2 mt-1">
	                                    <p>
	                                        <label>
	                                            <input type="checkbox" name='aceptar' id="aceptar" />
	                                            <span>Acepto las <a href="<?=$adpnsy->url_page($info->Politicas);?>" target="_blank">Políticas de privacidad</a></span>
	                                        </label>
	                                    </p>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="input-field col s12">
	                                	<input type="hidden" value='true' name="register">
	                                    <button type="submit" class="btn waves-effect waves-light <?=$info->botton_color?> <?=$info->botton_color_t?> <?=$info->botton_fondo?> <?=$info->botton_tono?> col s12">Registrarse</button>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <?php if ($info->Recovery) { ?>
		                                <div class="input-field col s6 m6 l6">
		                                    <p class="margin medium-small"><a href="<?=$adpnsy->url_page($info->Recovery);?>">Recuperar contraseña</a></p>
		                                </div>
	                            	<?php } ?>
	                                <div class="input-field col s6 m6 l6">
	                                    <p class="margin right-align medium-small"><a href="<?=$adpnsy->url_login();?>">Iniciar sesión</a></p>
	                                </div>
	                            </div>
	                        </form>
	                    </div>
	                </div>
	            </div>
	            <div class="content-overlay"></div>
	        </div>
	    </div>
	    <?=$adpnsy->footer()?>
	</body>
</html>