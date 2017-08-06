<?php 
  session_start();
  if (!isset($_SESSION['usuario']))
  {
    header("Location:../../index.php");
  } else {
?>

<!DOCTYPE html>
<html lang="ES">
<head>
  <title>MUNDIPACK | Administrador</title>

  <meta http-equiv="Content-Type" content="IE=Edge; chrome=1"> 
  <meta charset="UTF-8"">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="../default/assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/flat-admin.css">
  <link rel="stylesheet" type="text/css" href="../default/css/sweetalert.css">  

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/yellow.css">
  <link rel="stylesheet" href="../default/assets_acemaster/css/chosen.min.css" />

</head>
<body>
  <div class="app app-default">
<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-brand" href="../dashboard/"><span class="highlight">MUNDI</span>PACK</a>
    <button type="button" class="sidebar-toggle">
      <i class="fa fa-times"></i>
    </button>
  </div>


<!-- Sidebar Menu -->


  <div class="sidebar-menu" id="permisos">      
  </div>

<!-- Fin de SideBar Menú -->

  <div class="sidebar-footer">
    <ul class="menu">
      <li>
        <a href="/" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-cogs" aria-hidden="true"></i>
        </a>
      </li>
      <li><a href="#"><span class="flag-icon flag-icon-pe flag-icon-squared"></span></a></li>
    </ul>
  </div>
</aside>

<script type="text/ng-template" id="sidebar-dropdown.tpl.html">
  <div class="dropdown-background">
    <div class="bg"></div>
  </div>
  <div class="dropdown-container">
    {{list}}
  </div>
</script>


<div class="app-container">


<!-- Barra Superior -->
<nav class="navbarflat navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-collapse collapse in">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        </li>
        <li class="logo">
          <a class="navbar-brand" href="#"><span class="highlight">MUNDI</span>PACK</a>
        </li>
        <li>
          <button type="button" class="navbar-toggle">
            <img class="profile-img" src="../default/assets/images/profile.jpg">
          </button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title"><?php echo $_SESSION['usuarioNombres']; ?></li>        
      </ul>

      
      <!-- Menús despegables -->

      <ul class="nav navbar-nav navbar-right">
          <li class="dropdown notification warning hidden" id="pago_socios">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <div class="icon"><i class="fa fa-bank" aria-hidden="true"></i></div>
                  <div class="title">Nuevos Pagos de Net Partners</div>
                  <div class="count" id="noti_pagos_pre_socios"></div>
              </a>
              <div class="dropdown-menu">
                  <ul id="item_noti_pago_socio">
                  </ul>
              </div>
          </li>

          <li class="dropdown notification default hidden" id="pago_traveler">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <div class="icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                  <div class="title">Nuevos Pagos de Travelers</div>
                  <div class="count" id="noti_pagos_pre_travelers"></div>
              </a>
              <div class="dropdown-menu">
                  <ul id="item_noti_pago_traveler">
                  </ul>
              </div>
          </li>


        <li class="dropdown profile">
          <a href="/html/pages/profile.html" class="dropdown-toggle"  data-toggle="dropdown">
            <img class="profile-img" src="../../<?php echo $_SESSION['usuarioImagen'];?>" >
            <div class="title">Profile</div>
          </a>
          <div class="dropdown-menu">
            <div class="profile-info">
              <h4 class="username"><?php echo $_SESSION['usuarioNombres'];?></h4>
            </div>
            <ul class="action">
              <li>
                <a href="../cuenta/cuenta_admin.php">
                  Cuenta
                </a>
              </li>
              <li>
                <a href="../../view/controlusuario/logout.php">
                  Salir
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<input type="hidden" dissabled="true" value="Administrador" id="Menu">

  <div class="btn-floating" id="help-actions">
    <div class="btn-bg"></div>
    <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle" data-target="#help-actions">
      <i class="icon fa fa-plus"></i>
      <span class="help-text">Shortcut</span>
    </button>
    <div class="toggle-content">
      <ul class="actions">
        <li> 
          <button type="button" class="btn btn-primary" data-toggle="modal" onclick="nuevo();" data-target="#modalViajero">Nuevo TRAVELER</button>
        </li>
      </ul>
    </div>
  </div>

<div class="row">

 <div class="col-xs-12">
      <div class="card">
        <div class="card-header">
          Lista de TRAVELERS
        </div>
        <div class="card-body padding">
          <table class="datatable table table-striped primary" cellspacing="0" width="100%" id="viajeros">
            <thead>
                <tr>
                    <th style="font-size: 12px; height: 10px; text-align: center; width: 10%;">Nombres</th>
                    <th style="font-size: 12px; height: 10px; text-align: center; width: 1%;">DNI</th>                    
                    <th style="font-size: 12px; height: 10px; text-align: center; width: 3%;">Celular</th>
                    <th style="font-size: 12px; height: 10px; text-align: center; width: 10%;">Destino</th>
                    <th style="font-size: 12px; height: 10px; text-align: center; width: 1%;">Acumulado</th>
                    <th style="font-size: 12px; height: 10px; text-align: center; width: 1%;">Expansivo</th>
                    <th style="font-size: 12px; height: 10px; text-align: center; width: 2%;">Operaciones</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaViajeros">

            </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>

<!-- MODAL -->

    <div class="modal fade" id="modalViajero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" style="width: 70% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Nuevo TRAVELER</h4>
          </div>      

          <div class="modal-body">
            <div id="mensaje" class="col-md-12"></div>
            <form class="form form-horizontal" method="post" id="frm_nuevoViajero" style="font-size: 12px;">                  
                  <!-- Nombres -->
                  <div class="form-group col-md-6">
                    <label class="col-md-3 control-label">Nombres</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" placeholder="Nombres" name="viajeroNombre" id="viajeroNombre" >
                    </div>
                  </div>

                  <!-- Apellidos -->
                  <div class="form-group col-md-6">
                    <label class="col-md-3 control-label">Apellidos</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" placeholder="Apellidos" name="viajeroApellidos" id="viajeroApellidos" >
                    </div>
                  </div>

                  <!-- Nombre Comercial -->
                  <div class="form-group col-md-6">
                    <label class="col-md-3 control-label">DNI</label>
                    <div class="col-md-9" >
                      <input type="text" maxlength="8"  class="form-control" placeholder="N° Documento de Identidad" name="viajeroDNI" id="viajeroNombre" onkeypress="return solonumeros(event)">
                    </div>
                  </div>                

                  <!-- Fecha Nacimiento -->
                  <div class="form-group col-md-6">
                    <label class="col-md-3 control-label">Fecha Nacimiento</label>
                    <div class="col-md-6">
                      <input type="date" class="form-control" placeholder="Año-Mes-Día" name="viajeroNacimiento" id="viajeroNacimiento" >
                    </div>
                  </div>

                  <!-- Dirección -->
                  <div class="form-group col-md-8">
                    <div class="col-md-2">
                      <label class="control-label">Dirección</label>                      
                    </div>
                    <div class="col-md-8" style="padding-left: 4.5%;">
                      <textarea class="form-control"  name="viajeroDireccion" id="viajeroDireccion" placeholder="(Calle/Urbanización/Oficina/Distrito)"></textarea>
                    </div>
                  </div>                
                
                  <!-- Telefono -->
                  <div class="form-group col-md-12">
                    <div class="col-md-1">
                      <label class="control-label">Teléfono</label>
                    </div>                    
                    <div class="col-md-10" style="padding-left: 3.7%;">
                      <div class="col-md-5">
                        <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Fijo"  name="viajeroTelefonoFijo" id="viajeroTelefonoFijo">
                      </div>
                      <div class="col-md-5">
                        <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Celular"  name="viajeroTelefonoCelular" id="viajeroTelefonoCelular">
                      </div>                      
                    </div>
                  </div>                                

                  <!-- Email -->
                  <div class="form-group col-md-12">
                    <div class="col-md-1">
                      <label class="control-label">Email</label>
                    </div>                                 
                    <div class="col-md-7" style="padding-left: 5.5%;">
                      <input type="email" class="form-control" placeholder="email@example.com" name="viajeroEmail" id="viajeroEmail" >
                    </div>
                  </div>

                  <!-- Número de Pasaporte -->
                  <div class="form-group col-md-7">
                    <div class="col-md-3">
                      <label class="control-label">N° Pasaporte</label>
                    </div>                               
                    <div class="col-md-9" style="padding-left: 0%;">
                      <input class="form-control" placeholder="N° Pasaporte (Opcional)" onkeypress="return solonumeros(event)"  name="viajeroNroPasaporte" id="viajeroNroPasaporte">
                    </div>
                  </div>

                  <!-- Día Pago -->
                  <div class="form-group col-md-5">
                    <div class="col-md-4">
                      <label class="control-label">Día de Pago</label>
                    </div>                                 
                    <div class="col-md-5" style="padding-left: 0%;">
                      <input type="tel" class="form-control" placeholder="Día del mes" onkeypress="return solonumeros(event)" name="viajeroDiaPago" id="viajeroDiaPago" value="10">
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-md-3 control-label">Destino<br>Principal</label>
                      <div class="col-md-9" style="padding-left: 4.5%;" id="destinoPrincipal">

                      </div>
                  </div>                  
                  <div class="form-group col-md-6">                                        
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Menor"  name="menorprecio_principal" id="menorprecio_principal">
                    </div>
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Medio"  name="medioprecio_principal" id="medioprecio_principal">
                    </div>
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Mayor"  name="mayorprecio_principal" id="mayorprecio_principal">
                    </div>                                        
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-md-3 control-label">Destino Secundario</label>
                      <div class="col-md-9" style="padding-left: 4.5%;" id="destinoSecundario1">
                      </div>
                  </div>
                  <div class="form-group col-md-6">                                        
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Menor"  name="menorprecio_secundario1" id="menorprecio_secundario1">
                    </div>
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Medio"  name="medioprecio_secundario1" id="medioprecio_secundario1">
                    </div>
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Mayor"  name="mayorprecio_secundario1" id="mayorprecio_secundario1">
                    </div>                                        
                  </div>

                  <div class="form-group col-md-6">
                      <label class="col-md-3 control-label">Destino Secundario</label>
                      <div class="col-md-9" style="padding-left: 4.5%;" id="destinoSecundario2">

                      </div>
                  </div>
                  <br>
                  <div class="form-group col-md-6">                                        
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Menor"  name="menorprecio_secundario2" id="menorprecio_secundario2">
                    </div>
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Medio"  name="medioprecio_secundario2" id="medioprecio_secundario2">
                    </div>
                    <div class="col-md-4">
                      <input type="tel" class="form-control" readonly="true" placeholder="Mayor"  name="mayorprecio_secundario2" id="mayorprecio_secundario2">
                    </div>                                        
                  </div>

                  <div class="form-group col-md-12">
                    <div class="col-md-1">
                      <label class="control-label">Cuota</label>
                    </div>                                 
                    <div class="col-md-3" style="padding-left: 5.5%;">
                      <input type="tel" class="form-control" placeholder="Mínimo S/. 100" onkeypress="return solonumeros(event)" name="viajeroMontoPago" id="viajeroMontoPago" >
                    </div>
                  </div>

                  <!-- Viajero Abierto -->
                  <div class="form-group">
                    <label class="col-md-2 control-label" style="padding-left: 3.5%;">Viajero Expansivo</label>
                    <div class="col-md-1">
                      <input type="checkbox" value="1" class="form-control" name="viajeroAbierto" id="viajeroAbierto" >
                    </div>
                  </div>                    

                  <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                    <input style="display:none;" type="button" id="guardarViajero" data-dismiss="modal" class="btn btn-sm btn-primary" onclick="guardar();" value="Guardar"/>
                    <input style="display:none;" type="button" id="editarViajero" data-dismiss="modal" class="btn btn-sm btn-primary" onclick="editar();" value="Modificar"/>
                  </div>                
            </form>
          </div>
         
        </div>
      </div>
    </div>

  <footer class="app-footer"> 
    <div class="row">
      <div class="col-xs-12">
        <div class="footer-copyright">
          SodaTech+ © 2017  MUNDIPACK
        </div>
      </div>
    </div>
  </footer>
  </div>

  </div>
  
  <script type="text/javascript" src="../default/assets/js/vendor.js"></script>
  <script type="text/javascript" src="../default/assets/js/app.js"></script>
  <script type="text/javascript" src="../default/js/sweetalert.min.js"></script> 
  <script src="../default/js/listar_viajeros.js"></script> 
  <script src="../default/js/validaciones.js"></script>

  <script src="../default/assets_acemaster/js/chosen.jquery.min.js"></script>
  <script src="../default/assets_acemaster/js/jquery-ui.custom.min.js"></script>

</body>
</html>

<?php } ?>