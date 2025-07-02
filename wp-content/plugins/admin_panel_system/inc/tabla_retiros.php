<?php

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class listar_productos extends WP_List_Table
{

    public function prepare_items(){
      $this->process_bulk_action();
      $columns = $this->get_columns();
      $hidden = $this->get_hidden_columns();
      $sortable = $this->get_sortable_columns();

      $data = $this->table_data();
      if(count($data) > 0)
        usort( $data, array( &$this, 'sort_data' ) );
      $perPage = 20;
      $currentPage = $this->get_pagenum();
      $totalItems = count($data);
      $searchcol = array('nombre');

      if(count($data) > 0)
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
      if(count($data) > 0)
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
      $this->_column_headers = array($columns, $hidden, $sortable);
      $this->items = $data;
    }

    function no_items() {
      _e( 'No hay retiros.' );
    }

    public function get_columns(){
      
        $columns = array(
            'id'          => __('ID', 'adpnsy'),
            'user'           => __('Inversor', 'adpnsy'),
            'cuenta'           => __('Cuenta', 'adpnsy'),
            'cantidad'       => __('Cantidad', 'adpnsy'),
            'estado'       => __('Estado', 'adpnsy'),
            'fecha'       => __('Fecha', 'adpnsy'),
        );
        return $columns;
    }

    public function column_id($item) {
      $actions['espera'] = sprintf("<a href='%s'>%s</a>'",add_query_arg( "espera", $item['id']), __('En espera', 'adpnsy'));
      $actions['pagar'] = sprintf("<a href='%s'>%s</a>'",add_query_arg( "pagar", $item['id']), __('Pagado', 'adpnsy'));
      $actions['cancelar'] = sprintf("<a href='%s'>%s</a>'",add_query_arg( "cancelar", $item['id']), __('Cancelado', 'adpnsy'));
      return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions) );
    }

    public function column_user($item) {
    	$data_user = get_userdata($item['user']);
    	return $data_user->display_name . "($item[user])";
    }

    public function column_cantidad($item) {
      return sprintf('%.2f €', $item["cantidad"]);
    }

    public function column_estado($item) {
      switch ($item["estado"]) {
        case '1': return "<span style='color:green'>Pagado</span>"; break;
        case '2': return "<span style='color:red'>Cancelado</span>"; break;
        default:  return "<span style='color:orange'>En espera</span>"; break;
      }
    }

    public function get_sortable_columns(){
      return array(
        'id' => array('id', false),
        'user' => array('user', false),
        'cuenta'  => array('id', false),
        'cantidad' => array('cantidad', false),
        'estado' => array('estado', false),
        'fecha' => array('fecha', false)
      );
    }

    public function get_hidden_columns(){
      return array();
    }

    private function table_data(){
		$s = "";
		if(isset($_GET['s']) && $_GET['s']){
			$s = $_GET['s'];
			$s = "WHERE (id LIKE '%$s%' or cantidad LIKE '%$s%' or fecha LIKE '%$s%')";
		}

    if(isset($_GET['st']) && $_GET['st'] != ""){
      $s = $s?$s." AND ":"WHERE ";
      $s .= "estado = '$_GET[st]'";
    }

    if(isset($_GET['us']) && $_GET['us']){
      $s = $s?$s." AND ":"WHERE ";
      $s .= "user = '$_GET[us]'";
    }

		global $wpdb;
		$inv_transacciones = $wpdb->prefix . "inv_transacciones";

		return $wpdb->get_results( "SELECT * FROM $inv_transacciones $s;", ARRAY_A );
    }

    public function column_cuenta($item){
      $iban = get_user_meta( $item['user'], 'iban_user', true );
      $banc = get_user_meta( $item['user'], 'banco_user', true );
      if($iban && $banc) return "$banc - $iban";
      return "N/D";
    }

    public function column_default( $item, $column_name ){
        switch( $column_name ) {
            case 'id':
            case 'user':
            case 'cantidad':
            case 'user':
            case 'fecha':
                return $item[ $column_name ];
            case 'cuenta':
                return $item[ 'id' ];
            default:
                return print_r( $item, true ) ;
        }
    }

    public function extra_tablenav( $which ) {
      if ( $which == "top" ) : ?>
        <form  method="GET">
          <input type="hidden" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : ''; ?>">    
          <input type="hidden" name="page" value="adpnsy_retiros">
          <div class="alignleft actions">
            <label class="screen-reader-text" for="proveedores">Proveedores</label>
            <?php $users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) ); ?>
            <select name="us">
              <option value="">Seleccione un usuario</option>
              <?php foreach($users as $user){
                if(isset($_GET['us']) && $_GET['us'] == $user->ID){
                  echo "<option selected value='$user->ID'>$user->display_name</option>";
                }else{
                  echo "<option value='$user->ID'>$user->display_name</option>";
                }
              } ?>
            </select>
            <select name="st">
              <option value="">Seleccione un estado</option>
              <?php $_sts = [0 => "En espera", 1 => "Pagado", 2 => "Cancelado"]; foreach($_sts as $_ist => $_nst){
                if(isset($_GET['st']) && $_GET['st'] != "" && $_GET['st'] == $_ist){
                  echo "<option selected value='$_ist'>$_nst</option>";
                }else{
                  echo "<option value='$_ist'>$_nst</option>";
                }
              } ?>
            </select>
          </div>
          <?php submit_button( __( 'Apply' ), 'action', '', false, array( 'id' => "filter" ) ); ?>
        </form>
      <?php endif;
  }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b ){
        // Set defaults
        $orderby = 'id';
        $order = 'desc';
        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
        $result = strnatcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
    }

}


