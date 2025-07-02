<div class="breadcrumbs" id="breadcrumbs-wrapper">
  <div class="container">
    <div class="row">
      <div class="col s12">
        <div class="nav-wrapper">
            <div class="col s12">
                <a href="/dashboard" class="breadcrumb">Panel de administración</a>
                <a href="#" class="breadcrumb">Perfil de Usuario</a>
            </div>
        </div>
      </div>
      <div class="col s10 m6 l6">
        <h5 class="breadcrumbs-title mt-0 mb-0">Perfil de Usuario</h5>                
      </div>              
    </div>
  </div>
</div>
<div class="container">
  <div class="row">   
    <div class="col s12">
      <div class="container">
        <div class="section" id="user-profile">
          <div class="row">
            <div class="col s12">
              <div class="row">
                <div class="card user-card" id="feed">
                  <div class="card-content card-border-gray" >
                    <div class='<?=$mensaje?$mensaje['e']:"error";?>-login<?=$mensaje?" show":"";?>'><?=$mensaje['m'];?></div>
                    <form class="perfil-form" method="post" action="#">
                      <table style="width: 100%">
                        <tbody>
                          <tr>
                            <th>Usuario:</th>
                            <td><?=$user->user_login;?></td>
                          </tr>
                          <tr>
                            <th>Nombre:</th>
                            <td><input type="text" name="act[first_name]"value="<?=$user->first_name ;?>"></td>
                          </tr>
                          <tr>
                            <th>Apellido:</th>
                            <td><input type="text" name="act[last_name]" cont="" value="<?=$user->last_name;?>"></td>
                          </tr>
                          <tr>
                            <th>Correo:</th>
                            <td><input type="email" name="act[user_email]" cont="" value="<?=$user->user_email;?>" required></td>
                          </tr>
                          <tr>
                            <th>Cambio de contraseña:</th>
                            <td><input type="password" placeholder="En blanco para no editar" name="act[user_pass]"></td>
                          </tr>
                          <tr>
                            <td class="center-align" colspan="2">
                              <input type="hidden" value='true' name="save">
                              <button type="submit" id="panel_user_confirm" class="btn waves-effect waves-light <?=$info->botton_color?> <?=$info->botton_color_t?> <?=$info->botton_fondo?> <?=$info->botton_tono?> col s12">Guardar datos</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </form>
                  </div>
                </div>
              </div>
            </div>    
          </div>
        </div>
      </div>
    </div>
  </div>
</div>