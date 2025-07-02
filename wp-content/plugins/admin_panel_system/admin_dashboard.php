<?php 
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
$message_welcome_ = (!empty($user_data) && $user_data->data->display_name) ? "Panel de administración [{$user_data->data->display_name}]" : '';
if(in_array('administrator', $user_data->roles)){
    $message_welcome_ = "Panel de administración [Admin]";
}
if(!in_array('administrator', $user_data->roles) && !in_array('gestor_campamento', $user_data->roles)){
    wp_redirect(home_url());
    exit;
}
?>
<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
	<head>
        <link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/css/themes/vertical-dark-menu-template/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/css/themes/vertical-dark-menu-template/style.min.css">
	    <?=$adpnsy->header($info, false)?>
	</head>
	<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns" data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">
        <header class="page-topbar" id="header">
            <div class="navbar navbar-fixed">
                <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-light">
                    <div class="nav-wrapper">
                        <div class="welcome_message_">
                            <p><?= $message_welcome_ ?></p>
                        </div>
                        <ul class="navbar-list right">
                            <li>
                                <?php if( function_exists('icl_get_languages') ):
                                    $languages = icl_get_languages('skip_missing=0');
                                    $link = '<a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="language-dropdown">';
                                    $menu = '<ul class="dropdown-content" id="language-dropdown">';
                                    foreach($languages as $language) {
                                        if($language['active']) {
                                            $link .= '<img src="' . $language['country_flag_url'] . '" alt="' . $language['native_name'] . '" /></a>';
                                      
                                        } else {
                                            $menu .= '<li><a href="' . $language['url'] . '"><img src="' . $language['country_flag_url'] . '" alt="' . $language['native_name'] . '" /></a></li> ';
                                        }
                                    }
                                    echo $link . $menu . "</ul>";
                                endif;
                                ?>
                            </li>
                            <li>
                                <?php $nts = $adpnsy->notificacion(); ?>
                                <a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown">
                                    <i class="material-icons">notifications_none<?=$nts['c'];?></i>
                                </a>
                                <ul class="dropdown-content" id="notifications-dropdown" tabindex="0">
                                    <li tabindex="0">
                                        <h6>Notificaciones
                                            <?=$nts['t'];?>
                                        </h6>
                                    </li>
                                    <li class="divider" tabindex="0"></li>
                                    <?=$nts['n'];?>
                                </ul>
                            </li>
                            <li>
                                <a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown">
                                    <span class="avatar-status avatar-online">
                                        <img src="<?=$adpnsy->avatar();?>" alt="avatar">
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <?php $adpnsy->menu("perfil_admin_system", "dropdown-content", "profile-dropdown"); ?>
                    </div>
                </nav>
            </div>
        </header>
        <aside class="blue_TOPCamp sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
            <div class="brand-sidebar">
                <h1 class="logo-wrapper"><a class="brand-logo darken-1 ctm_img_TOP" href="<?=get_site_url();?>"><img class="hide-on-med-and-down " src="<?=$info->logo_blanco;?>" alt="materialize logo" /><img class="show-on-medium-and-down hide-on-med-and-up" src="<?=$info->logo;?>" alt="materialize logo" /><span class="logo-text hide-on-med-and-down"><?=$info->logo_texto;?></span></a></h1>
            </div>
            <?php 
                $user_id = get_current_user_id();
                $user_data = get_userdata($user_id);
                if(in_array('administrator', $user_data->roles)){
                    $adpnsy->menu("perfil_admin_system__admin", "sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow", "admin-slide-out"); 
                }else if(in_array('gestor_campamento', $user_data->roles)){
                    $adpnsy->menu("admin_system", "sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow", "slide-out"); 
                }
            ?>
            <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
        </aside>
        <div id="main">
        	<?=$adpnsy->contenido();?>
        </div>
        <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
            <div class="footer-copyright">
                <div class="container"><span>&copy; <?=date("Y")?> <a href="<?= home_url() ?>" target="_blank">TOP Campamentos</a> All rights reserved.</span><span class="right hide-on-small-only"><img class="footer-logo" src="<?= home_url('/wp-content/uploads/2023/04/favicon-asp.png') ?>" />Diseñado y desarrollado por <a href="https://agenciasp.com/" target="_blank">Agencia Digital SP</a></span></div>
            </div>
        </footer>
        <?=$adpnsy->footer(false)?>
	</body>
</html>