<?php 

global $wpdb;
$tabla = $wpdb->prefix . 'jet_post_types';
$metadata_TOP = $wpdb->get_var("SELECT meta_fields FROM $tabla WHERE slug='topcampamentos'");
$metadata_TOP = unserialize($metadata_TOP);
$metadata_trat_TOP = array();
foreach($metadata_TOP as $k => $v){
    if($v['type'] == 'checkbox' || $v['type'] == 'select'  || $v['type'] == 'radio'){
        $metadata_trat_TOP[$v['name']] = $v['options'];
    }
}

function print_meta_defaults($array, $value){
    if(!is_array($value)) $value = array($value);
    elseif(is_array($value)){
        $pos_array = [];
        $pos_value = [];
        foreach($array as $a) $pos_array[] = $a['key'];
        foreach($value as $vk => $vl) $pos_value[] = $vk;
        $diff = array_diff($pos_array, $pos_value);
        foreach($value as $k => $v){
            if($v == 'true'){
                echo "<option selected value='{$k}'>{$k}</option>";
            }else{
                echo "<option value='{$k}'>{$k}</option>";
            }
        }
        foreach($diff as $d){
            echo "<option value='{$d}'>{$d}</option>";
        }
        return;
    }
    foreach($array as $k => $v){
        if(in_array($v['key'], $value)){
            echo "<option selected value='{$v['key']}'>{$v['value']}</option>";
        }else{
            echo "<option value='{$v['key']}'>{$v['value']}</option>";
        }
    }
}

$key_implement = uniqid();

?>
<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/quill/quill.snow.css">
<div class="container_form_steps <?= $camp_edit ?>">
        <form action="" class="data_topcampamento_" id="data_topcampamento_">
            <div class="instalaciones_media">
                <label for="">Biblioteca de Imágenes *</label>
                <p class="message_top_add_clue nmr">
                    <i class="material-icons icon-menu">info</i>
                    Sube al menos 4 imágenes para la galería de tu campamento. Recuerda que las imágenes que subas para la galería deben tener un tamaño mínimo de 1200px por 800px.
                </p>
                <div class="media_slider_camps">
                    <i class="material-icons icon-menu">image</i>
                </div>
                <button class="new_lilbrary_btn" act="custom_dropify_ajax">Selecciona Imágenes de tu campamento</button>
            </div>
            <div class="portada_media">
                <label for="">Imagenes de portada de tu campamento</label>
                <p class="message_top_add_clue smr">
                    <i class="material-icons icon-menu">info</i>
                    La imagen de portada de tu campamento será la primera impresión para los usuarios. Esta se visualizara así como en el ejemplo de abajo. La imagen de portada debe tener un tamaño mínimo de 512px por 512px.
                </p>
                <div class="content-sides">
                    <div class="sides_media_admin">
                        <div class="card_fake">
                            <div class="head">
                                <span class="portada">Portada</span>
                                <div class="acti">
                                    <span></span>
                                </div>
                            </div>
                            <div class="body">
                                <div class="title"><span></span></div>
                                <div class="region"><span></span></div>
                                <div class="lang"><span></span></div>
                                <div class="prine"><span></span><span></span></div>
                                <button><span></span></button>
                            </div>
                        </div>
                    </div>
                    <div class="sides_media_admin">
                        <div class="field_portada" act="custom_dropify_ajax"><i class="material-icons icon-menu">image</i></div>
                    </div>
                </div>
            </div>
            <div class="data_basic_camps">
                <span class="bocadillo">
                    Datos básicos de tu campamento
                </span>
                <div class="content_data_basic">
                    <div class="img_profile">
                        <div class="img_portada_camp" act="custom_dropify_ajax">
                            <i class="material-icons icon-menu">image</i>
                        </div>
                        <p class="message_top_add_clue nmr">
                            <i class="material-icons icon-menu">info</i>
                            Asegúrate de que el logotipo de tu campamento tenga un tamaño mínimo de 200px por 200px.
                        </p>
                    </div>
                    <div class="camp_title">
                        <div class="input-field">
                            <input type="text" id="title_u_camp" name="camp_title" data-length="75" value="<?= ($data_update_camp['title']) ? $data_update_camp['title'] : null ?>" required>
                            <label for="title_u_camp" class="label_material">Título de tu campamento (al menos 7 caracteres)</label>
                        </div>
                    </div>
                    <div class="camp_description">
                        <div class="input-field">
                            <label for="" class="label_quill_fields">Descripción de tu campamento (al menos 250 caracteres)</label>
                            <textarea class="top_format_text_coe_txt" ttlf="descripción" name="descripcion" id="desc_camp" maxlength="1100" style="height: 45px;"><?= ($data_update_camp['descripcion']) ? $data_update_camp['descripcion'] : null ?></textarea>
                            <div class="top_format_text_coe" taid="desc_camp"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tags_camps">
                <span class="bocadillo">
                    Tags de tu campamento
                </span>
                <div class="content_tags_camps">
                    <div class="tag">
                        <label for="actividades">Temática</label>
                        <select name="actividades" id="" topval="actividades">
                            <option value="" <?= ($data_update_camp['actividades']) ? '' : 'selected' ?> disabled >Temática | </option>
                            <?php print_meta_defaults($metadata_trat_TOP['actividades'], ($data_update_camp['actividades']) ? $data_update_camp['actividades'] : ''); ?>
                        </select>
                    </div>
                    <div class="tag">
                        <label for="region">Región</label>
                        <select name="region" id="" topval="region">
                            <option value="" <?= ($data_update_camp['region']) ? '' : 'selected' ?> disabled >Región | </option>
                            <?php print_meta_defaults($metadata_trat_TOP['region'], ($data_update_camp['region']) ? $data_update_camp['region'] : ''); ?>
                        </select>
                    </div>
                    <div class="tag">
                        <label for="idioma">Idioma</label>
                        <select name="idioma[]" id="" topval="idioma" multiple>
                            <option value="" <?= ($data_update_camp['idioma']) ? '' : 'selected' ?> disabled >Idioma | </option>
                            <?php print_meta_defaults($metadata_trat_TOP['idioma'], ($data_update_camp['idioma']) ? $data_update_camp['idioma'] : ''); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="desc_instal_activity">
                <span class="bocadillo">
                    Instalaciones y actividades de tu campamento
                </span>
                <div class="content_des_instal_activity">
                    <div class="instal_desc">
                        <div class="input-field">
                            <label for="" class="label_quill_fields">Descripción de las intalaciones de tu campamento (al menos 250 caracteres)</label>
                            <div class="top_format_text_coe" taid="desc_inst"></div>
                            <textarea class="top_format_text_coe_txt" ttlf="instalaciones descripción" name="instalaciones-descripcion" id="desc_inst" maxlength="1100" data-length="1100" style="height: 45px;"><?= ($data_update_camp['instalaciones-descripcion']) ? $data_update_camp['instalaciones-descripcion'] : null ?></textarea>
                        </div>
                    </div>
                    <div class="activity_desc">
                        <label for="actividades2">Actividades</label>
                        <select name="actividades2[]" id="" multiple class="browser-default" topval="actividades2">
                            <option value="" <?= ($data_update_camp['actividades2']) ? '' : 'selected' ?> disabled >Actividades | </option>
                            <?php print_meta_defaults($metadata_trat_TOP['actividades2'], ($data_update_camp['actividades2']) ? $data_update_camp['actividades2'] : ''); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="details_camps">
                <span class="bocadillo">
                    Detalles de tu campamento
                </span>
                <div class="content_details">
                    <div class="details">
                        <div class="input-field">
                            <label for="" class="label_quill_fields">Detalles (Destacamos por:) (al menos 250 caracteres)</label>
                            <textarea class="top_format_text_coe_txt" ttlf="seguros" name="detalles_seguros" id="det_seg" maxlength="1100" style="height: 45px;"><?= ($data_update_camp['detalles_seguros']) ? $data_update_camp['detalles_seguros'] : null ?></textarea>
                            <div class="top_format_text_coe" taid="det_seg"></div>
                        </div>
                    </div>
                    <div class="details">
                        <div class="input-field">
                            <label for="" class="label_quill_fields">Detalles (Incluye) (al menos 250 caracteres)</label>
                            <div class="top_format_text_coe" taid="det_men"></div>    
                            <textarea class="top_format_text_coe_txt" ttlf="menú" name="detalles_menu" id="det_men" maxlength="1100" style="height: 45px;"><?= ($data_update_camp['detalles_menu']) ? $data_update_camp['detalles_menu'] : null ?></textarea>
                        </div>
                    </div>
                    <div class="details">
                        <div class="input-field">
                            <label for="" class="label_quill_fields">Información acerca de la ubicación de tu campamento (al menos 250 caracteres)</label>
                            <div class="top_format_text_coe" taid="det_ubi"></div>    
                            <textarea class="top_format_text_coe_txt" ttlf="ubicación" name="detalles_ubicacion" id="det_ubi" maxlength="1100" style="height: 45px;"><?= ($data_update_camp['detalles_ubicacion']) ? $data_update_camp['detalles_ubicacion'] : null ?></textarea>
                        </div>
                    </div>
                    <div class="details">
                        <div class="input-field">
                            <label for="" class="label_quill_fields">Detalles (Otros: seguros, menús, descuentos...) (al menos 250 caracteres)</label>
                            <div class="top_format_text_coe" taid="det_can"></div>    
                            <textarea class="top_format_text_coe_txt" ttlf="cancelación" name="detalles_cancelacion" id="det_can" maxlength="1100" style="height: 45px;"><?= ($data_update_camp['detalles_cancelacion']) ? $data_update_camp['detalles_cancelacion'] : null ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data_clue">
                <span class="bocadillo">
                    Datos clave de tu campamento
                </span>
                <p class="message_top_add_clue">
                    <i class="material-icons icon-menu">info</i>
                    Para añadir otras fechas, precios, temporadas y duraciones de tu campamento, por favor presiona el botón 'Añadir otros' que se encuentra debajo de los datos a continuación.
                    Por favor, asegúrate de incluir el IVA en el precio que ingreses.
                </p>
                <div class="container_data_clue_inside">
                    <?php if(isset($_GET['edit_campamento'])) {
                        $ix = 1;
                        $data_update_camp_clue_dj = json_decode($data_update_camp_clue);
                        foreach($data_update_camp_clue_dj as $key_implement_clue => $v){ 
                            $__fecha_i = ($v->fecha_inicio) ? $v->fecha_inicio : '';
                            if($__fecha_i){
                                $__fecha_i = explode('/', $__fecha_i);
                                $__fecha_i = $__fecha_i[2].'/'.$__fecha_i[1].'/'.$__fecha_i[0];
                            }
                            $__fecha_f = ($v->fechas_final) ? $v->fechas_final : '';
                            if($__fecha_f){
                                $__fecha_f = explode('/', $__fecha_f);
                                $__fecha_f = $__fecha_f[2].'/'.$__fecha_f[1].'/'.$__fecha_f[0];
                            }
                            ?>
                            <div class="content_data_clue" cd="<?= $ix ?>">
                                <?php if($ix > 1) { ?>
                                    <button class="quit_data_clue" act="dlt_data_clue" cd="<?= $ix ?>">
                                        <i class="material-icons icon-menu">close</i>
                                    </button>
                                <?php } ?>
                                <div class="clues">
                                    <label for="cluecamp[<?= $key_implement_clue ?>][fecha_inicio]">Fecha inicial de tu campamento *</label>
                                    <input type="text" value="<?= $__fecha_i ?>" class="date-input" name="cluecamp[<?= $key_implement_clue ?>][fecha_inicio]" required placeholder="Fecha inicial de tu campamento *" >
                                </div>
                                <div class="clues">
                                    <label for="cluecamp[<?= $key_implement_clue ?>][fechas_final]">Fecha final de tu campamento *</label>
                                    <input type="text" value="<?= $__fecha_f ?>" class="date-input" name="cluecamp[<?= $key_implement_clue ?>][fechas_final]" required placeholder="Fecha final de tu campamento *" >
                                </div>
                                <div class="clues">
                                    <label for="cluecamp[<?= $key_implement_clue ?>][precio]">Precio * (iva incl.)</label>
                                    <input type="number" min="1" class="price_clue_top" value="<?= ($v->precio) ? $v->precio : '' ?>" name="cluecamp[<?= $key_implement_clue ?>][precio]" required placeholder="Precio * (iva incl.)" >
                                </div>
                                <div class="clues">
                                    <label for="cluecamp[<?= $key_implement_clue ?>][mes-temporada]">Temporada</label>
                                    <select name="cluecamp[<?= $key_implement_clue ?>][mes-temporada]" topval="mes-temporada" required>
                                        <option value="" selected disabled >Temporada</option>
                                    <?php print_meta_defaults($metadata_trat_TOP['mes-temporada'], ($v->{'mes-temporada'}) ? $v->{'mes-temporada'} : ''); ?>
                                    </select>                    
                                </div>
                                <div class="clues">
                                    <label for="cluecamp[<?= $key_implement_clue ?>][duracion]">Duración</label>
                                    <select name="cluecamp[<?= $key_implement_clue ?>][duracion]" topval="duracion" required>
                                        <option value="" selected disabled >Duración</option>
                                    <?php print_meta_defaults($metadata_trat_TOP['duracion'], ($v->{'duracion'}) ? $v->{'duracion'} : ''); ?>
                                    </select>                    
                                </div>
                                <div class="clues">
                                    <label for="cluecamp[<?= $key_implement_clue ?>][edades]">Edades</label>
                                    <select name="cluecamp[<?= $key_implement_clue ?>][edades]" id="" topval="edades" required>
                                        <option value="" selected disabled >Edades | </option>
                                        <?php print_meta_defaults($metadata_trat_TOP['edades'], ($v->{'edades'}) ? $v->{'edades'} : ''); ?>
                                    </select>                  
                                </div>
                                <div class="clues">
                                    <label for="cluecamp[<?= $key_implement_clue ?>][plazas_num]">Plazas a la venta por TOP Campamentos *</label>
                                    <input type="number" value="<?= ($v->plazas_num) ? $v->plazas_num : '' ?>" name="cluecamp[<?= $key_implement_clue ?>][plazas_num]" required placeholder="Plazas a la venta por TOP Campamentos *" >                 
                                </div>
                            </div>
                        <?php 
                        $ix++;
                        }
                    } else { ?>
                        <div class="content_data_clue" cd="1">
                            <div class="clues">
                                <label for="cluecamp[<?= $key_implement ?>][fecha_inicio]">Fecha inicial de tu campamento *</label>
                                <input type="text" class="date-input" name="cluecamp[<?= $key_implement ?>][fecha_inicio]" required placeholder="Fecha inicial de tu campamento *" >
                            </div>
                            <div class="clues">
                                <label for="cluecamp[<?= $key_implement ?>][fechas_final]">Fecha final de tu campamento *</label>
                                <input type="text" class="date-input" name="cluecamp[<?= $key_implement ?>][fechas_final]" required placeholder="Fecha final de tu campamento *" >
                            </div>
                            <div class="clues">
                                <label for="cluecamp[<?= $key_implement ?>][precio]">Precio * (iva incl.)</label>
                                <input type="number" min="1" class="price_clue_top" name="cluecamp[<?= $key_implement ?>][precio]" required placeholder="Precio * (iva incl.)" >
                            </div>
                            <div class="clues">
                                <label for="cluecamp[<?= $key_implement ?>][mes-temporada]">Temporada</label>
                                <select name="cluecamp[<?= $key_implement ?>][mes-temporada]" topval="mes-temporada" required>
                                    <option value="" selected disabled >Temporada</option>
                                <?php print_meta_defaults($metadata_trat_TOP['mes-temporada'], ''); ?>
                                </select>                    
                            </div>
                            <div class="clues">
                                <label for="cluecamp[<?= $key_implement ?>][duracion]">Duración</label>
                                <select name="cluecamp[<?= $key_implement ?>][duracion]" topval="duracion" required>
                                    <option value="" selected disabled >Duración</option>
                                <?php print_meta_defaults($metadata_trat_TOP['duracion'], ''); ?>
                                </select>                    
                            </div>
                            <div class="clues">
                                <label for="cluecamp[<?= $key_implement ?>][edades]">Edades</label>
                                <select name="cluecamp[<?= $key_implement ?>][edades]" id="" topval="edades" required>
                                    <option value="" selected disabled >Edades | </option>
                                    <?php print_meta_defaults($metadata_trat_TOP['edades'], ''); ?>
                                </select>                  
                            </div>
                            <div class="clues">
                                <label for="cluecamp[<?= $key_implement ?>][plazas_num]">Plazas a la venta por TOP Campamentos *</label>
                                <input type="number" name="cluecamp[<?= $key_implement ?>][plazas_num]" required placeholder="Plazas a la venta por TOP Campamentos *" >                 
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <button class="add_data_clue" act="add_data_clue_camp">Añadir otros</button>
            </div>
            <div class="services_camps">
                <span class="bocadillo">
                    Servicios de tu campamento
                </span>
                <div class="content_services_camps">
                    <div class="services">
                        <label for="servicios_tipo_alojamiento">Tipo de alojamiento</label>
                        <select name="servicios_tipo_alojamiento" topval="servicios_tipo_alojamiento">
                            <option value="" <?= ($data_update_camp['servicios_tipo_alojamiento']) ? '' : 'selected' ?> disabled>Tipo de alojamiento</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_tipo_alojamiento'], ($data_update_camp['servicios_tipo_alojamiento']) ? $data_update_camp['servicios_tipo_alojamiento'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_alojamiento">Alojamiento</label>
                        <select name="servicios_alojamiento" topval="servicios_alojamiento">
                            <option value="" <?= ($data_update_camp['servicios_alojamiento']) ? '' : 'selected' ?> disabled>Alojamiento</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_alojamiento'], ($data_update_camp['servicios_alojamiento']) ? $data_update_camp['servicios_alojamiento'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_monitores">Monitores</label>
                        <select name="servicios_monitores" topval="servicios_monitores">
                            <option value="" <?= ($data_update_camp['servicios_monitores']) ? '' : 'selected' ?> disabled>Monitores</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_monitores'], ($data_update_camp['servicios_monitores']) ? $data_update_camp['servicios_monitores'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_centro_salud">Centro de salúd</label>
                        <select name="servicios_centro_salud" topval="servicios_centro_salud">
                            <option value="" <?= ($data_update_camp['servicios_centro_salud']) ? '' : 'selected' ?> disabled>Centro de salúd</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_centro_salud'], ($data_update_camp['servicios_centro_salud']) ? $data_update_camp['servicios_centro_salud'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_plazas">Plazas</label>
                        <select name="servicios_plazas" topval="servicios_plazas">
                            <option value="" <?= ($data_update_camp['servicios_plazas']) ? '' : 'selected' ?> disabled>Plazas</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_plazas'], ($data_update_camp['servicios_plazas']) ? $data_update_camp['servicios_plazas'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_alimentacion">Alimentación</label>
                        <select name="servicios_alimentacion" topval="servicios_alimentacion">
                            <option value="" <?= ($data_update_camp['servicios_alimentacion']) ? '' : 'selected' ?> disabled>Alimentación</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_alimentacion'], ($data_update_camp['servicios_alimentacion']) ? $data_update_camp['servicios_alimentacion'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_experiencia">Experiencia</label>
                        <select name="servicios_experiencia" topval="servicios_experiencia">
                            <option value="" <?= ($data_update_camp['servicios_experiencia']) ? '' : 'selected' ?> disabled>Experiencia</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_experiencia'], ($data_update_camp['servicios_experiencia']) ? $data_update_camp['servicios_experiencia'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_area_privada">Área privada</label>
                        <select name="servicios_area_privada" topval="servicios_area_privada">
                            <option value="" <?= ($data_update_camp['servicios_area_privada']) ? '' : 'selected' ?> disabled>Área privada</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_area_privada'], ($data_update_camp['servicios_area_privada']) ? $data_update_camp['servicios_area_privada'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_socorrista">Socorrista</label>
                        <select name="servicios_socorrista" topval="servicios_socorrista">
                            <option value="" <?= ($data_update_camp['servicios_socorrista']) ? '' : 'selected' ?> disabled>Socorrista</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_socorrista'], ($data_update_camp['servicios_socorrista']) ? $data_update_camp['servicios_socorrista'] : ''); ?>
                        </select>
                    </div>
                    <div class="services">
                        <label for="servicios_enfermero">Enfermero</label>
                        <select name="servicios_enfermero" topval="servicios_enfermero">
                            <option value="" <?= ($data_update_camp['servicios_enfermero']) ? '' : 'selected' ?> disabled>Enfermero</option>
                        <?php print_meta_defaults($metadata_trat_TOP['servicios_enfermero'], ($data_update_camp['servicios_enfermero']) ? $data_update_camp['servicios_enfermero'] : ''); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="ubicacion">
                <span class="bocadillo">
                    Dirección de tu campamento
                </span>
                <div class="ubi_content">
                    <input type="text" autocomplete="off" name="ubication_iframe" id="ubication_iframe" value="<?= ($data_update_camp['ubication_iframe']) ? $data_update_camp['ubication_iframe'] : null  ?>" required placeholder="Dirección de tu campamento. Ejemplo: Barrio Chino Calle #20, Madrid, España">
                </div>
            </div>
            <div class="save_form">
                <input type="hidden" name="id_camp_current" value="<?= ($data_update_camp['id']) ? $data_update_camp['id'] : null  ?>" class="data_id_camp_current">
                <div class="progress_bar">
                    <span class="percent">
                        <p>0</p>% completado
                    </span>
                    <div class="unick_bar"></div>
                </div>
                <div class="options_out_sys_camp">
                    <button dtrsv="save_like_draft">Guardar como borrador</button>
                    <button class="no_publy" dtrsv="save_like_publy">Publicar</button>
                </div>
            </div>
        </form>
</div>

<div class="overlay_custom_dropify disable">
    <div class="content">
        <i class="material-icons icon-menu close_custom_dropify">close</i>
        <div class="photos">
            <h2 class="title_library_updtcmp">Mi biblioteca</h2>
            <div class="content_photos">
            </div>
            <div class="add_photo">
                <button act="show_upload_image">Añadir a mi biblioteca</button>
                <button class="select_medias disabled">Seleccionar</button>
            </div>
        </div>
        <div class="upload_images">
            <form id="custom_dropify_adpnsy" enctype="multipart/form-data">
                <label for="">Subir archivos</label>
                <input type="file" class="dropify" data-max-file-size="1M" data-allowed-file-extensions="jpg png svg" data-default-file="" name="imagen_top_camp" id="img_custom_panel_camp" required>
                <div class="dts_img">
                    <input type="text" name="nombre_img" placeholder="Nombre de la imagen" required>
                </div>
                <button class="save_custom_dropify">Guardar</button>
            </form>
            <div class="back_photos_upload" act="hide_upload_image">
                <i class="material-icons icon-menu">arrow_back</i>
                <span>Medios</span>
            </div>
        </div>
    </div>
</div>


<?php 
    $ids_portada = ($data_update_camp['portada_camp']) ? $data_update_camp['portada_camp'][0] : 'false';
    $ids_foto = ($data_update_camp['foto']) ? (int)$data_update_camp['foto'][0] : 'false';
    $ids_instalaciones = ($data_update_camp['instalaciones']) ? $data_update_camp['instalaciones'][0] : 'false';
    $foto = array();
    $instalaciones = array();
    $portada = array();
    if($ids_foto){
        $foto['id'] = $ids_foto;
        $foto['url'] = wp_get_attachment_url($ids_foto);
        $foto['title'] = get_the_title($ids_foto);
    }

    if($ids_instalaciones){
        $mid = explode(',', $ids_instalaciones);
        foreach($mid as $k => $v){
            $v = (int)$v;
            $instalaciones[$k]['id'] = $v;
            $instalaciones[$k]['url'] = wp_get_attachment_url($v);
            $instalaciones[$k]['title'] = get_the_title($v);
        }
    }

    if($ids_portada){
        $portada['id'] = $ids_portada;
        $portada['url'] = wp_get_attachment_url($ids_portada);
        $portada['title'] = get_the_title($ids_portada);
    }

?>

<script>
    const temporada = <?php echo json_encode($metadata_trat_TOP['mes-temporada']); ?>;
    const duracion = <?php echo json_encode($metadata_trat_TOP['duracion']); ?>;
    const edades = <?php echo json_encode($metadata_trat_TOP['edades']); ?>;
    const foto = <?php echo json_encode($foto); ?>;
    const instalaciones = <?php echo json_encode($instalaciones); ?>;
    const portada = <?php echo json_encode($portada); ?>;
</script>
<script type="text/javascript" id="api_places_script_top" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBo-lGYg-ONjQV0WqOAX8kaN6VBcyN4FEs&libraries=places"></script>
<script src="<?=ADPNSY_URL;?>app-assets/vendors/quill/quill.min.js"></script>