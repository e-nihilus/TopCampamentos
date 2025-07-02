<?php
//poner el meta key para que solo aparezcan los suyos
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
if(!in_array('gestor_campamento', $user_data->roles)){
    wp_redirect(home_url());
    exit;
}
if(isset($_GET) && isset($_GET['topcamp'])) { 
    $data_camp = array();
    $data_update_camp = array();
    $data_update_camp['title'] = '';
    $data_update_camp['descripcion'] = '';
    $data_update_camp['actividades'] = '';
    $data_update_camp['region'] = '';
    $data_update_camp['mes-temporada'] = [];
    $data_update_camp['edades'] = [];
    $data_update_camp['duracion'] = [];
    $data_update_camp['instalaciones'] = '';
    $data_update_camp['servicios_tipo_alojamiento'] = '';
    $data_update_camp['servicios_alojamiento'] = '';
    $data_update_camp['servicios_monitores'] = '';
    $data_update_camp['servicios_centro_salud'] = '';
    $data_update_camp['servicios_plazas'] = '';
    $data_update_camp['servicios_alimentacion'] = '';
    $data_update_camp['servicios_experiencia'] = '';
    $data_update_camp['servicios_area_privada'] = '';
    $data_update_camp['servicios_socorrista'] = '';
    $data_update_camp['servicios_enfermero'] = '';
    $data_update_camp['detalles_seguros'] = '';
    $data_update_camp['detalles_menu'] = '';
    $data_update_camp['detalles_ubicacion'] = '';
    $data_update_camp['detalles_cancelacion'] = '';
    $data_update_camp['instalaciones-descripcion'] = '';
    $data_update_camp['actividades2'] = [];
    $data_update_camp['precio'] = '';
    $data_update_camp['foto'] = '';
    $data_update_camp['portada_camp'] = '';
    $data_update_camp['ubication_iframe'] = '';
    $data_update_camp['instalaciones'] = '';
    $data_update_camp['idioma'] = [];
    $data_update_camp['id'] = '';
    if(isset($_GET['edit_campamento'])){
        $camp_edit = intval($_GET['edit_campamento']);
        $current_post = get_post($camp_edit);
        if($current_post && $current_post->post_type == 'topcampamentos'){
            if($current_post->post_author == get_current_user_id() || current_user_can('administrator')){
                $meta_data_current_post = get_post_meta($camp_edit);
                $data_update_camp['title'] = $current_post->post_title;
                $data_update_camp['descripcion'] = ($meta_data_current_post['descripcion'][0]) ? $meta_data_current_post['descripcion'][0] : '';
                $data_update_camp['actividades'] = ($meta_data_current_post['actividades'][0]) ? $meta_data_current_post['actividades'][0] : '';
                $data_update_camp['region'] = ($meta_data_current_post['region'][0]) ? $meta_data_current_post['region'][0] : '';
                $data_update_camp['mes-temporada'] = ($meta_data_current_post['mes-temporada'][0]) ? unserialize($meta_data_current_post['mes-temporada'][0]) : '';
                $data_update_camp['edades'] = ($meta_data_current_post['edades'][0]) ? unserialize($meta_data_current_post['edades'][0]) : '';
                $data_update_camp['duracion'] = ($meta_data_current_post['duracion'][0]) ? unserialize($meta_data_current_post['duracion'][0]) : '';
                $data_update_camp['instalaciones'] = ($meta_data_current_post['instalaciones']) ? $meta_data_current_post['instalaciones'] : '';
                $data_update_camp['servicios_tipo_alojamiento'] = ($meta_data_current_post['servicios_tipo_alojamiento'][0]) ? $meta_data_current_post['servicios_tipo_alojamiento'][0] : '';
                $data_update_camp['servicios_alojamiento'] = ($meta_data_current_post['servicios_alojamiento'][0]) ? $meta_data_current_post['servicios_alojamiento'][0] : '';
                $data_update_camp['servicios_monitores'] = ($meta_data_current_post['servicios_monitores'][0]) ? $meta_data_current_post['servicios_monitores'][0] : '';
                $data_update_camp['servicios_centro_salud'] = ($meta_data_current_post['servicios_centro_salud'][0]) ? $meta_data_current_post['servicios_centro_salud'][0] : '';
                $data_update_camp['servicios_plazas'] = ($meta_data_current_post['servicios_plazas'][0]) ? $meta_data_current_post['servicios_plazas'][0] : '';
                $data_update_camp['servicios_alimentacion'] = ($meta_data_current_post['servicios_alimentacion'][0]) ? $meta_data_current_post['servicios_alimentacion'][0] : '';
                $data_update_camp['servicios_experiencia'] = ($meta_data_current_post['servicios_experiencia'][0]) ? $meta_data_current_post['servicios_experiencia'][0] : '';
                $data_update_camp['servicios_area_privada'] = ($meta_data_current_post['servicios_area_privada'][0]) ? $meta_data_current_post['servicios_area_privada'][0] : '';
                $data_update_camp['servicios_socorrista'] = ($meta_data_current_post['servicios_socorrista'][0]) ? $meta_data_current_post['servicios_socorrista'][0] : '';
                $data_update_camp['servicios_enfermero'] = ($meta_data_current_post['servicios_enfermero'][0]) ? $meta_data_current_post['servicios_enfermero'][0] : '';
                $data_update_camp['detalles_seguros'] = ($meta_data_current_post['detalles_seguros'][0]) ? $meta_data_current_post['detalles_seguros'][0] : '';
                $data_update_camp['detalles_menu'] = ($meta_data_current_post['detalles_menu'][0]) ? $meta_data_current_post['detalles_menu'][0] : '';
                $data_update_camp['detalles_ubicacion'] = ($meta_data_current_post['detalles_ubicacion'][0]) ? $meta_data_current_post['detalles_ubicacion'][0] : '';
                $data_update_camp['detalles_cancelacion'] = ($meta_data_current_post['detalles_cancelacion'][0]) ? $meta_data_current_post['detalles_cancelacion'][0] : '';
                $data_update_camp['instalaciones-descripcion'] = ($meta_data_current_post['instalaciones-descripcion'][0]) ? $meta_data_current_post['instalaciones-descripcion'][0] : '';
                $data_update_camp['actividades2'] = ($meta_data_current_post['actividades2'][0]) ? unserialize($meta_data_current_post['actividades2'][0]) : $meta_data_current_post['actividades2'][0];
                $data_update_camp['precio'] = ($meta_data_current_post['precio']) ? $meta_data_current_post['precio'] : '';
                $data_update_camp['foto'] = ($meta_data_current_post['foto']) ? $meta_data_current_post['foto'] : '';
                $data_update_camp['portada_camp'] = ($meta_data_current_post['portada_camp']) ? $meta_data_current_post['portada_camp'] : '';
                $data_update_camp['ubication_iframe'] = ($meta_data_current_post['ubication_iframe'][0]) ? $meta_data_current_post['ubication_iframe'][0] : '';
                $data_update_camp['instalaciones'] = ($meta_data_current_post['instalaciones']) ? $meta_data_current_post['instalaciones'] : '';
                $data_update_camp['idioma'] = ($meta_data_current_post['idioma'][0]) ? unserialize($meta_data_current_post['idioma'][0]) : '';
                $data_update_camp['id'] = $current_post->ID;
                $data_update_camp_clue = ($meta_data_current_post['cluecamp'][0]) ? : '';
                include 'parts/camp_update.php';
            }else{
                echo '
                        <div class="content_mssg_error_for_get">
                            <p class="message_top_add_clue">
                                <i class="material-icons icon-menu">info</i>
                                Lo sentimos, no tiene acceso para editar otros publicaciones que no sean las suyas
                            </p>
                        </div>';
                include 'parts/camp_pg_dash.php';
            }
        }else{
            echo '
            <div class="content_mssg_error_for_get">
                <p class="message_top_add_clue">
                    <i class="material-icons icon-menu">info</i>
                    Lo sentimos, no tiene acceso para editar otros publicaciones que no sean las suyas
                </p>
            </div>'; 
            include 'parts/camp_pg_dash.php';
        }
    }else{
        include 'parts/camp_update.php';
    }
}else{
    include 'parts/camp_pg_dash.php';
}