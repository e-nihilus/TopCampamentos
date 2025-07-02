<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".viwer_register").click(function(e){
			e.preventDefault();
			var _dts = JSON.parse($(this).attr("dts"));
			$.each(_dts, function(k,v){
				$(".exty_body td[attr='"+k+"']").text(v);
			})
			if(_dts.data_user){
				if(!_dts.code){
					$(".exty_footer a").text("Desactivar acceso");
					$(".exty_footer a").attr("href", "admin.php?page=spuser&desactivar=" + _dts.id);
				}else{
					$(".exty_footer a").text("Activar acceso");
					$(".exty_footer a").attr("href", "admin.php?page=spuser&activar=" + _dts.id);
				}
			}else{
				$(".exty_footer a").text("Aprobar");
				$(".exty_footer a").attr("href", "admin.php?page=spuser&aprobar=" + _dts.id);
			}
			$(".exty_viwer").fadeIn();
		})
		$(".exty_close").click(function(e){
			$(".exty_viwer").fadeOut();
		})
	});
</script>
<style type="text/css">
	.exty_viwer {
		display: none;
	    background-color: #ffffffb3;
	    position: fixed;
	    width: 100%;
	    height: 100%;
	    z-index: 99999;
	    left: 0;
	    top: 0;
	}

	.exty_box {
	    background-color: white;
	    position: absolute;
	    width: 500px;
	    left: calc(50% - 250px);
	    top: 20%;
	    box-shadow: 0px 0px 10px #636363;
	}

	.exty_header {
	    padding: 10px;
	    border-bottom: 1px solid #ccc;
	}

	.exty_header p {
	    margin: 0;
	    font-size: 20px;
	    font-weight: bold;
	}

	.exty_body {
	    padding: 10px;
	}

	.exty_body table {
	    width: 100%;
	    border-collapse: collapse;
	    border: 1px solid #ccc;
	}

	.exty_body table th {
	    width: 150px;
	    text-align: left;
	}

	.exty_body table tr * {
	    border-bottom: 1px solid #ccc;
	    padding: 10px;
	    transition: .5s all;
	}

	.exty_body table > tbody > tr:nth-last-child(1) > * {
	    border: none;
	}

	.exty_body table > tbody > tr:nth-child(2n) > * {
	    background-color: #f7f6f6;
	}

	.exty_body table th:after {content: ":";}

	.exty_body table tr:hover * {
	    background-color: #d2d2d2 !important;
	}

	.exty_footer {
	    display: flex;
	    padding: 10px 5px;
	    border-top: 1px solid #ccc;
	}

	.exty_btn {
	    background-color: #838383;
	    border: none;
	    padding: 10px 20px;
	    width: 100%;
	    color: #fff;
	    font-size: 15px;
	    text-align: center;
	    margin: 0 5px;
	    text-decoration: none;
	    cursor: pointer;
	    transform: scale(1);
	    transition: .5s all;
	}

	a.exty_btn {
	    background-color: #2271b1;
	}

	a.exty_btn:hover {
	    color: #fff;
	    text-decoration: none;
	    transform: scale(1.05);
	}
	.exty_header .exty_close {
	    background-color: red;
	    border: none;
	    position: absolute;
	    right: 0;
	    top: 0;
	    height: 50px;
	    width: 50px;
	    font-size: 19px;
	    color: #fff;
	    cursor: pointer;
	}
</style>
<div class="exty_viwer">
	<div class="exty_box">
		<div class="exty_header">
			<p>Datos de usuario</p>
			<button class="exty_close">X</button>
		</div>
		<div class="exty_body">
			<table>
				<tbody>
					<tr>
						<th>CIF</th>
						<td attr="cif"></td>
					</tr>
					<tr>
						<th>Nombre comercial</th>
						<td attr="nombre_comercial"></td>
					</tr>
					<tr>
						<th>Nombre fiscal</th>
						<td attr="nombre_fiscal"></td>
					</tr>
					<tr>
						<th>Dirección</th>
						<td attr="direccion"></td>
					</tr>
					<tr>
						<th>Población</th>
						<td attr="poblacion"></td>
					</tr>
					<tr>
						<th>Provincia</th>
						<td attr="provincia"></td>
					</tr>
					<tr>
						<th>Código Postal</th>
						<td attr="zip"></td>
					</tr>
					<tr>
						<th>Responsable</th>
						<td attr="responsable"></td>
					</tr>
					<tr>
						<th>Teléfono</th>
						<td attr="telefono"></td>
					</tr>
					<tr>
						<th>Teléfono móvil</th>
						<td attr="movil"></td>
					</tr>
					<tr>
						<th>Correo electrónico</th>
						<td attr="correo"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="exty_footer">
			<button class="exty_btn exty_close">Cerrar</button>
			<a href="admin.php?page=spuser&aprobar=" class="exty_btn">Aprobar</a>
		</div>
	</div>
</div>