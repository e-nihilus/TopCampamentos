<?php 
$gestor = get_current_user_id();
if(!user_can($gestor, 'gestor_campamento')){
    wp_redirect(home_url());
    exit;
}
$campamentos = get_posts(['author' => $gestor, 'posts_per_page' => -1, 'post_type' => 'topcampamentos']);
?>

<div class="row mt-5">
    <div class="col l6 m6 s12 mb-5">
        <div class="row card table-top-camps bck-pq-p bck-pq">
            <div class="col s12">
                <h2 class="title_pqts_">Visibilidad destacada</h2>
                <p class="desc_paqts visi">¡Aumenta la visibilidad en tus campamentos por solo 200€ + IVA durante 30 días!</p>
            </div>
            <div class="col s12 mtb-p">
                <select id="camp_select_visibility" tp="visibility">
                    <option value="" selected disabled>Elige un campamento</option>
                    <?php 
                    if(!empty($campamentos)){
                        foreach($campamentos as $camp){ ?>
                        <option value="<?= $camp->ID ?>"><?= $camp->post_title ?></option>
                    <?php }} ?>
                </select>
            </div>
            <div class="col s12 cntn-btn-pq">
                <button class="visibility btn_pq" tp="visibility"><i class="material-icons icon-menu">shopping_cart_checkout</i> Comprar</button>
            </div>
        </div>
    </div>
    <div class="col l6 m6 s12 mb-5">
        <div class="row card table-top-camps bck-pq-s bck-pq">
            <div class="col s12">
                <h2 class="title_pqts_">Certificación</h2>
                <p class="desc_paqts destc">¡Destaca tu campamento con nuestra línea destacada con sello por solo 30€ + IVA!</p>
            </div>
            <div class="col s12 mtb-p">
                <select id="camp_select_certify" tp="certify">
                    <option value="" selected disabled>Elige un campamento</option>
                    <?php 
                    if(!empty($campamentos)){
                        foreach($campamentos as $camp){ ?>
                        <option value="<?= $camp->ID ?>"><?= $camp->post_title ?></option>
                    <?php }} ?>
                </select>
            </div>
            <div class="col s12 cntn-btn-pq">
                <button class="certify btn_pq" tp="certify"><i class="material-icons icon-menu">shopping_cart_checkout</i> Comprar</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col l6 m6 s12 mb-5">
        <div class="row card table-top-camps">
            <div class="col s12">
                <h2 class="ttle_cmps_plns_pqts">Campamentos con visibilidad destacada</h2>
            </div>
            <div class="col s12">
                <?php 
                    $args = array(
                        'post_type' => 'topcampamentos',
                        'author' => $gestor, 
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'venc_camp_dest_30',
                                'compare' => 'EXISTS',
                            ),
                        ),
                    );
                    $posts = get_posts($args);
                    if(!empty($posts)){ ?>
                        <div class="container_pqts_cmps_info mt-5">
                            <div class="content_pqts_cmps_info">
                                <table id="tbl_pqts_cmps_visibility">
                                    <thead>
                                        <tr>
                                            <th>Campamentos</th>
                                            <th>Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($posts as $post){ 
                                                $time = get_post_meta($post->ID, 'venc_camp_dest_30', true);
                                                $time = ($time) ? date('d-m-Y', $time): '';
                                                ?>
                                                <tr>
                                                    <td><?= $post->post_title ?></td>
                                                    <td><?= $time ?></td>
                                                </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <span class="empty_mssg_pqts_cmps">Sin campamentos con visibilidad destacada</span>
                <?php }                 
                ?>
            </div>
        </div>
    </div>
    <div class="col l6 m6 s12 mb-5">
        <div class="row card table-top-camps">
            <div class="col s12">
                <h2 class="ttle_cmps_plns_pqts">Campamentos con certificación</h2>
            </div>
            <div class="col s12">
                <?php 
                    $args = array(
                        'post_type' => 'topcampamentos',
                        'author' => $gestor, 
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'certify_by_TOP',
                                'compare' => 'EXISTS',
                            ),
                        ),
                    );
                    $posts = get_posts($args);
                    if(!empty($posts)){ ?>
                        <div class="container_pqts_cmps_info mt-5">
                            <div class="content_pqts_cmps_info">
                                <table id="tbl_pqts_cmps_certify">
                                    <thead>
                                        <tr>
                                            <th>Campamentos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach($posts as $post){ ?>
                                            <tr>
                                                <td><?= $post->post_title ?></td>
                                            </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <span class="empty_mssg_pqts_cmps">Sin campamentos con certificación</span>
                <?php }                 
                ?>
            </div>
        </div>
    </div>
</div>