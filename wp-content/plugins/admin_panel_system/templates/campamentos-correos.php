<?php 
$gestor = get_current_user_id();
if(!user_can($gestor, 'gestor_campamento')){
    wp_redirect(home_url());
    exit;
}
?>
<link rel="stylesheet" type="text/css" href="<?=ADPNSY_URL;?>app-assets/vendors/quill/quill.snow.css">

<div class="row mt-3">
    <div class="col s12">
        <div class="message_top_adpnsy">
            <p>
            Hey gestores de campamentos, ¿sabían que pueden personalizar el mensaje que reciben los campistas al reservar su campamento? Solo hagan clic en el ícono del correo azul para escribir el mensaje. ¡Ofrezcan una experiencia única y memorable a los campistas para que se sientan como en casa!
            <br>
            Recuerden que si no configuran un mensaje, se enviará uno por defecto. Así que personalícenlo para que los campistas se sientan bienvenidos y reciban información importante sobre su estadía en el campamento.
            </p>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col s12">
        <div class="card material-table table-top-camps load_booking_rs_table">
            <table id="mails_camps">
                <thead>
                    <tr>
                        <th>Campamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $args = array(
                        'post_type'      => 'topcampamentos',
                        'posts_per_page' => -1,
                        'post_status'    => array('publish', 'draft'),
                        'author'         => get_current_user_id(),
                    );
                    $posts = get_posts($args);
                    foreach ($posts as $post) { ?>
                    <tr>
                        <td> <?= $post->post_title ?> </td>
                        <td class="camps_acts">
                            <a href="#" class="btns_ml_camp" mli="<?= $post->ID ?>">
                                <i class="material-icons icon-menu" mli="<?= $post->ID ?>" title="Configurar mensaje">mail</i>
                            </a>
                        </td>
                    </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal_quill_mail" class="disabled">
    <div class="container_quill_content">
        <i class="material-icons icon-menu tbl_ml_close">close</i>
        <div class="content_quill">
            <div id="cusom_mails_adpnsy">
            </div>
            <div class="footer_quill_top row mt-2 ">
                <div class="col m7 l9 xl9 s12">
                    <select name="" id="var_entr">
                        <option value="010" selected disabled>Variables de entorno</option>
                        <option value="{{nombre_campamento}}">Nombre campamento</option>
                        <option value="{{nombre_completo_cliente}}">Nombre completo cliente</option>
                        <option value="{{nombre_cliente}}">Nombre cliente</option>
                        <option value="{{apellido_cliente}}">Apellido cliente</option>
                        <option value="{{fechas_contratadas}}">Fechas contratadas</option>
                        <option value="{{plazas_contratadas}}">Plazas contratadas</option>
                        <option value="{{cantidad_deuda}}">Cantidad faltante</option>
                        <option value="{{telefono_cliente}}">Teléfono cliente</option>
                        <option value="{{campamento_edades}}">Edades campamento</option>
                        <option value="{{campamento_enlace}}">Enlace campamento</option>
                        <option value="{{cuenta_usuario}}">Cuenta usuario</option>
                    </select>
                </div>
                <div class="col m5 l3 xl3 s6">
                    <button class="btn col save_mail_custom_top_panel width-100 back_prin_second">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=ADPNSY_URL;?>app-assets/vendors/quill/quill.min.js"></script>