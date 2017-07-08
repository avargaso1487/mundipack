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
  <link rel="stylesheet" type="text/css" href="../default/css/estrellas.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/flat-admin.css">
  <link rel="stylesheet" type="text/css" href="../default/css/sweetalert.css">  

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/yellow.css">

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
          <button type="button" class="btn btn-primary" data-toggle="modal" onclick="nuevo();" data-target="#modalSocio">Nuevo NET PARTNER</button>
        </li>
      </ul>
    </div>
  </div>

<div class="row">
 <div class="col-xs-12">
      <div class="card">
        <div class="card-header">
          Lista de NET PARTNERS
        </div>
        <div class="card-body padding">
          <table class="table-responsive datatable table table-striped primary" cellspacing="0" width="100%" id="socios">
            <thead>
                <tr>                    
                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Nombre</th>
                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">RUC</th>
                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Rubro</th>                    
                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Telefono</th>
                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">% Retorno</th>
                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Categoría</th>
                    <th style="font-size: 12px; text-align: center; height: 10px; width: 2%;">Operaciones</th>                    
                </tr>
            </thead>

            <tbody id="cuerpoTablaSocios">
               

            </tbody>
        </table>

        </div>
      </div>
    </div>
    </div>




<!-- MODAL -->

    <div class="modal fade" id="modalSocio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Nuevo NET PARTNER</h4>
            
          </div>      

          <div class="modal-body">

          <div id="mensaje" class="col-md-12"></div>
            <form class="form form-horizontal" method="post" id="frm_nuevoSocio" style="font-size: 12px;">
                                    
                  <!-- Razón Social -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Razón Social</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" placeholder="Razón Social" name="socioRazonSocial" id="socioRazonSocial" >
                    </div>
                  </div>

                  <!-- RUC -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">RUC</label>
                    <div class="col-md-9">
                      <input type="text" maxlength="11" class="form-control" placeholder="RUC" onkeypress="return solonumeros(event)" name="socioRUC" id="socioRUC" >
                    </div>
                  </div>

                  <!-- Nombre Comercial -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Nombre Comercial</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" placeholder="Nombre Comercial" name="socioNombreComercial" id="socioNombreComercial" >
                    </div>
                  </div>                

                  <!-- Rubro Empresarial -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Rubro</label>
                    <div class="col-md-9">
                      <select class="form-control" id="socioRubro" name="socioRubro">
                        <option value="" disabled selected style="display: none;">Seleccionar Rubro</option>
                        <option value="3">Cafetería</option>
                        <option value="4">Hotel</option>
                        <option value="1">Restaurante</option>
                        <option value="2">SPA</option>
                      </select>                      
                    </div>
                  </div>
                  
                  <br>
                  <!-- Dirección -->
                  <div class="form-group">
                    <div class="col-md-3">
                      <label class="control-label">Dirección</label>
                      <p class="control-label-help">(Calle/Urbanización/<br>Oficina/Distrito)</p>
                    </div>
                    <div class="col-md-9">
                      <textarea class="form-control"  name="socioDireccion" id="socioDireccion" ></textarea>
                    </div>
                  </div>

                  <!-- Telefono -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Teléfono</label>
                    <div class="col-md-9">
                      <div class="col-md-6">
                        <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Contacto"  name="socioTelefonoContacto" id="socioTelefonoContacto">
                      </div>
                      <div class="col-md-6">
                        <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Atención"  name="socioTelefonoAtencion" id="socioTelefonoAtencion">
                      </div>                      
                    </div>
                  </div>                

                  <!-- Email -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Email</label>
                    <div class="col-md-9">
                      <input type="email" class="form-control" placeholder="email@example.com" name="socioEmail" id="socioEmail" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Nro. Cuenta</label>
                    <div class="col-md-9">
                      <input class="form-control" placeholder="Número de Cuenta" name="socioNroCuenta" id="socioNroCuenta" maxlength="5">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Contacto Responsable</label>
                    <div class="col-md-9">
                      <input class="form-control" placeholder="Nombre del Contacto" name="socioContactoResponsable" id="socioContactoResponsable" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">% de Retorno</label>
                    <div class="col-md-9">
                      <input class="form-control" placeholder="% de Retorno" name="socioPrctjRetorno" id="socioPrctjRetorno" >
                    </div>
                  </div>                

                  <div class="form-group">
                    <label class="col-md-3 control-label">Categoría</label>
                    <div class="col-md-2">
                      <p class="clasificacion">
                            <input type="radio" name="socioCategoria" id="socioCategoria1" value="5"><!--
                        --><label for="socioCategoria1">★</label><!--
                        --><input id="socioCategoria2" type="radio" name="socioCategoria"  value="4"><!--
                        --><label for="socioCategoria2">★</label><!--
                        --><input id="socioCategoria3" type="radio" name="socioCategoria" value="3"><!--
                        --><label for="socioCategoria3">★</label><!--
                        --><input id="socioCategoria4" type="radio" name="socioCategoria" value="2"><!--
                        --><label for="socioCategoria4">★</label><!--
                        --><input id="socioCategoria5" type="radio" name="socioCategoria" value="1"><!--
                        --><label for="socioCategoria5">★</label>
                      </p>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                    <input style="display:none;" type="button" id="guardarSocio" data-dismiss="modal" class="btn btn-sm btn-primary" onclick="guardar();" value="Guardar"/>
                    <input style="display:none;" type="button" id="editarSocio" data-dismiss="modal" class="btn btn-sm btn-primary" onclick="editar();" value="Modificar"/>
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
  <script src="../default/js/listar_socios.js"></script>
  <script src="../default/js/validaciones.js"></script>
</body>
</html>

<?php } ?>