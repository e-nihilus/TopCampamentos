<?php 
$gestor = get_current_user_id();
if(!user_can($gestor, 'gestor_campamento')){
    wp_redirect(home_url());
    exit;
}

$her_camps = array(
    'post_type'      => 'topcampamentos',
    'user'           => $gestor,
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'author'         => $gestor,
);
$camps = get_posts($her_camps);
$data_filter = [];
if(!empty($camps)){
    foreach($camps as $k => $v){
        $camp_id = $v->ID;
        $data_filter[$k]['id'] = $camp_id;
        $data_filter[$k]['title'] = $v->post_title;
    }
}

?>

<div class="filter_booking_adp filter_booking_adpnsy_pg row mt-3 fill">
    <div class="col s12">
        <div class="card material-table table-top-camps row valign-wrapper">
            <div class="col s4">
                <select name="" id="select_fil_booking_camp">
                    <option value="" selected>Todos los campamentos</option>
                    <?php if(!empty($data_filter)){
                        foreach($data_filter as $k){ ?>
                        <option value="<?= $k['id'] ?>"><?= $k['title'] ?></option>
                        <?php }
                    } ?>
                </select>
            </div>
            <div class="col s2">
                <input name="date1" type="text" class="date-input" placeholder="Desde">
            </div>
            <div class="col s2">
                <input name="date2" type="text" class="date-input" placeholder="Hasta">
            </div>
            <div class="col s2">
                <button class="filter_booking_btn btn btn-valid fil no_fil width-100 back_top_second">Filtrar</button>
            </div>
            <div class="col s3">
                <button class="csv_reservas btn width-100 back_down_second" nonce="<?=wp_create_nonce(get_current_user_id());?>">Descargar csv</button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col s12">
        <div class="card material-table table-top-camps load_booking_rs_table">
            <table id="reservas_campamentos">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Campamento</th>
                        <th>Fecha</th>
                        <th>Reservas</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Teléfono</th>
                        <th>DNI/NIF</th>
                        <th style="width: 100px">Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal_rs_info_pg" class="disabled">
    <div class="container_content">
        <div class="content_modal_rs_pg">
            <i class="material-icons icon-menu tbl_rs_close">close</i>
            <h2>Reserva #<span></span></h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Campamento</th>
                        <th>Fechas</th>
                        <th>Plazas</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>