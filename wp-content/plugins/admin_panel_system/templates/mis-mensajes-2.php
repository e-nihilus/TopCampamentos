<?php 
$gestor = get_current_user_id();
if(!user_can($gestor, 'gestor_campamento')){
    wp_redirect(home_url());
    exit;
}
?>
<div class="container">
 	<div class="row">
 		<div class="col s12">
 			<div class="card material-table table-top-camps load_booking_rs_table mt-3">
                <?php
                global $wpdb;
                $top_mensajes = $wpdb->prefix . "top_mensajes";
                $campamentos = get_posts(['author' => get_current_user_id(), 'posts_per_page' => -1, 'post_type' => 'topcampamentos', 'fields' => 'ids']);

                if(isset($_GET['id_m']) && is_numeric($_GET['id_m']) && !empty($campamentos)){
                    $_camps = implode(",", $campamentos);
                    $id = (int)$_GET['id_m'];
                    $mensaje = $wpdb->get_row("SELECT * FROM $top_mensajes WHERE id='$id' AND campamento IN ($_camps)");
                    $user = get_current_user_id();
                    if($mensaje){
                        if($mensaje->estado == 0){
                            $wpdb->update($top_mensajes, ["estado" => 1], ["id" => $mensaje->id]);
                            $mensaje->estado = 1;
                        } 
                        ///nuevo mensaje
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if(isset($_POST['msg_text']) && trim($_POST['msg_text'])){
                                $nm = [
                                    "message"       => sanitize_text_field(trim($_POST['msg_text'])),
                                    "user"          => $user,
                                    "campamento"    => $mensaje->campamento,
                                    "padre"         => $mensaje->id
                                ];
                                if($wpdb->insert($top_mensajes, $nm) !== false){
                                    global $info;
                                    $author_id = $mensaje->user;
                                    $mail = $author_id ? get_the_author_meta( 'user_email', $author_id ) : get_option("admin_email");
                                    $nombre = $author_id ? get_the_author_meta( 'display_name', $author_id ) : '';
                                    $url = get_option( "siteurl" ) . "/mi-cuenta/mensajes/?id_m=" . $id;
                                    $_data = [
                                        "nombre" => $nombre,
                                        "mensaje" => "Hola $nombre,<br><br>Tienes un nuevo mensaje, para leerlo y responder por favor ingrese a <a target='_blank' href='$url'>este enlaces</a><br><br><br>Si no puedes acceder al enlace prueba copiar y pegar esta URL en tu navegador $url"
                                    ];
                                    $this->mail($mail, __("Nuevo mensaje en TOP Campamentos", 'adpnsy'), "notificacion", $_data, $info);
                                    $wpdb->update($top_mensajes, ["estado" => 2], ["id" => $mensaje->id]);
                                    $mensaje->estado = 2;
                                }
                            }
                        }

                        $mensajes = $wpdb->get_results("SELECT message, fecha, user FROM $top_mensajes WHERE padre = {$mensaje->id} ORDER BY fecha ASC");
                        ?>
                        <link rel="stylesheet" id="dashicons-css" href="<?=ADPNSY_URL;?>/css/mensaje_items_panel.css" media="all">
                        <div class="msg-box">
                            <div class="msg-head">
                                <label class="msd-item">Fecha:<span><?=date("d/m/Y", strtotime($mensaje->fecha));?></span></label>
                                <label class="msd-item">Campamento:<span><?=get_the_title($mensaje->campamento) ?? "---";?></span></label>
                                <label class="msd-item">Asunto:<span><?=$mensaje->orden ? __("Información de la orden #",'adpnsy') . $mensaje->orden : __("Información del campamento",'adpnsy'); ?></span></label>
                                <label class="msd-item">Estado:<span><?=$mensaje->estado == 0 ? __('Nuevo','adpnsy') : '';?><?=$mensaje->estado == 1 ? __('Leído','adpnsy') : '';?><?=$mensaje->estado == 2 ? __('Respondido','adpnsy') :'';?></span></label>
                            </div>
                            <div class="msg-hist">
                                <p class="msg-text msg-campamento"><?=$mensaje->message;?><span><?=date("H:i d/m/Y", strtotime($mensaje->fecha));?></span></p>
                                <?php if(count($mensajes)) foreach($mensajes as $m){ ?>
                                    <p class="msg-text <?=$m->user == $user ? 'msg-user' : 'msg-campamento' ?>"><?=$m->message?><span><?=date("H:i d/m/Y", strtotime($m->fecha));?></span></p>
                                <?php } ?>
                            </div>
                            <form action="#" method="post" class="msg-n-mensaje">
                                <input type="text" class="msg-n-text browser-default" name="msg_text" placeholder="Escriba su mensaje" required />
                                <input type="submit" class="msg-n-send" value="Enviar" />
                            </form>
                        </div>
                        <script type="text/javascript">
                            const element = document.querySelector(".msg-hist");
                            element.scrollTop = element.scrollHeight;
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                        </script>
                    <?php }else{
                        echo "<p>".__('Mensaje no encontrado.','adpnsy')."</p>";
                    }
                }else{ ?>
     				<table id="mails_camps">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Campamento</th>
                                <th>Asunto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(empty($campamentos)){ ?>
                                    <tr><td colspan="5" class="center"><?=__('Sin campamentos','adpnsy')?></td></tr>
                                <?php }else{
                                    $_camps = implode(",", $campamentos);
                                    $mensajes = $wpdb->get_results("SELECT id, campamento, estado, fecha, orden FROM $top_mensajes WHERE campamento IN ({$_camps}) AND padre = 0 ORDER BY estado ASC");
                                    if(count($mensajes)) foreach($mensajes as $m){ ?>
                                        <tr>
                                            <td><?=date("d/m/Y", strtotime($m->fecha));?></td>
                                            <td><?=get_the_title($m->campamento);?></td>
                                            <td><?=$m->orden ? __("Información de la orden #",'adpnsy') . $m->orden : __("Información del campamento",'adpnsy'); ?></td>
                                            <td>
                                                <span class="chip <?=$m->estado == 2 ? 'green' : ($m->estado == 1 ? 'blue' : 'red')?> white-text">
                                                    <?=$m->estado == 0 ? __('Nuevo','adpnsy') : '';?>
                                                    <?=$m->estado == 1 ? __('Leído','adpnsy') : '';?>
                                                    <?=$m->estado == 2 ? __('Respondido','adpnsy') :'';?>
                                                </span>
                                            </td>
                                            <td><a href="<?=get_permalink()?>?id_m=<?=$m->id;?>" title="Ver conversación"><i class="material-icons icon-menu">visibility</i></a></td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr><td colspan="5" class="center"><?=__('Sin mensajes','adpnsy')?></td></tr>
                                    <?php }
                                }
                            ?>
                        </tbody>
                    </table>
                <?php } ?>
 			</div>
 		</div>
 	</div>
 </div>