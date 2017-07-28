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
                                    <img class="profile-img" src="../../<?php echo $_SESSION['usuarioImagen'];?>" >
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
                                    <img class="profile-img" src="../../<?php echo $_SESSION['usuarioImagen'];?>">
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
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 12%;">Nombre</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">RUC</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Rubro</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Telefono</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">% Retorno</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Día Pago</th>
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
                <div class="modal-dialog" style="width: 75% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Nuevo NET PARTNER</h4>

                        </div>
                        <div class="modal-body">
                            <div id="mensaje" class="col-md-12"></div>
                            <form class="form form-horizontal" method="post" id="frm_nuevoSocio" style="font-size: 12px;">

                                <!-- Razón Social -->
                                <div class="form-group col-md-8">
                                    <label class="col-md-3 control-label">Razón Social</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Razón Social" name="socioRazonSocial" id="socioRazonSocial" >
                                    </div>
                                </div>
                                <!-- RUC -->
                                <div class="form-group col-md-4">
                                    <label class="col-md-3 control-label">RUC</label>
                                    <div class="col-md-9">
                                        <input type="text" maxlength="11" class="form-control" placeholder="RUC" onkeypress="return solonumeros(event)" name="socioRUC" id="socioRUC" >
                                    </div>
                                </div>
                                <!-- Nombre Comercial -->
                                <div class="form-group col-md-8">
                                    <label class="col-md-3 control-label">Nombre Comercial</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Nombre Comercial" name="socioNombreComercial" id="socioNombreComercial" >
                                    </div>
                                </div>
                                <!-- Rubro Empresarial -->
                                <div class="form-group col-md-4">
                                    <label class="col-md-3 control-label">Rubro</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="socioRubro" name="socioRubro">
                                            <option value="" disabled selected style="display: none;">Seleccionar Rubro</option>
                                            <option value="3">Cafetería</option>
                                            <option value="5">Boutique</option>
                                            <option value="6">Clínica</option>
                                            <option value="7">Discoteca</option>
                                            <option value="4">Hotel</option>
                                            <option value="1">Restaurante</option>
                                            <option value="2">SPA</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <!-- Dirección -->
                                <div class="form-group col-md-12">
                                    <div class="col-md-2">
                                        <label class="control-label">Dirección</label>
                                        <p class="control-label-help">(Calle/Urbanización/<br>Oficina/Distrito)</p>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea class="form-control"  name="socioDireccion" id="socioDireccion" ></textarea>
                                    </div>
                                </div>
                                <!-- Telefono -->
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Teléfono</label>
                                    <div class="col-md-9">
                                        <div class="col-md-4" style="padding-left: 0px;">
                                            <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Contacto"  name="socioTelefonoContacto" id="socioTelefonoContacto">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Atención"  name="socioTelefonoAtencion" id="socioTelefonoAtencion">
                                        </div>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="form-group col-md-7">
                                    <label class="col-md-4 control-label">Email</label>
                                    <div class="col-md-8"  style="padding-left: 4.5%">
                                        <input type="email" class="form-control" placeholder="email@example.com" name="socioEmail" id="socioEmail" >
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="col-md-3 control-label">Nro. Cuenta</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="Número de Cuenta" onkeypress="return solonumeros(event)" name="socioNroCuenta" id="socioNroCuenta" >
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label class="col-md-3 control-label">Contacto Responsable</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="Nombre del Contacto" name="socioContactoResponsable" id="socioContactoResponsable" >
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="col-md-3 control-label">% de Retorno</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="% de Retorno" name="socioPrctjRetorno" id="socioPrctjRetorno" onkeypress="return SoloNumerosDecimales3(event, '0.0', 6, 2);">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" style="padding-left: 3%;">Precios Desde</label>
                                    <div class="col-md-2" style="padding-left: 2%;">
                                        <input class="form-control"  placeholder="Precio"  name="socioPrecioDesde" id="socioPrecioDesde" onkeypress="return SoloNumerosDecimales3(event, '0.0', 6, 2);"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" style="padding-left: 3%;">Día Pago</label>
                                    <div class="col-md-2" style="padding-left: 2%;">
                                        <input class="form-control"  placeholder="Día límite"  name="socioDiaPago" id="socioDiaPago" onkeypress="return SoloNumerosDecimales3(event, '0.0', 6, 2);"/>
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

            <div class="modal fade" id="modalDatosNetPartner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width: 70% !important;">
                    <div class="modal-content" id="NPModalContent">
                        <!--
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" style="text-align: center; font-size: 18px; color: blue">DATOS DEL NET PARTNER</h4>

                        </div>

                        <div class="modal-body" id="modalNetPartner">                            
                            <div class="col-xs-12 col-sm-4">
                                <div>
                                  <span class="profile-img">
                                    <img class="img-responsive" alt="Net Partner" src="../default/assets/images/profile.png" />
                                  </span>
                                  <div class="space-4" id="RazonSocial"></div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-5">                                
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Razón Social: <b style="font-size: 14px;">Restaurante Jorge S.A.C.</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Nombre Comercial: <b style="font-size: 14px;">Restaurantes Coquitos Libereños</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Rubro: <b style="font-size: 14px;">Restaurante</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">RUC: <b style="font-size: 14px;">12345612345</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Dirección: <b style="font-size: 14px;">Manco Inca 723</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">T. Contacto: <b style="font-size: 14px;">044401566</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">T. Atención: <b style="font-size: 14px;">984799195</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Email: <b style="font-size: 14px;">avargaso@gmail.com</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">N° Cuenta: <b style="font-size: 14px;">10293847593</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Contacto Responsable: <b style="font-size: 14px;">Carlos Alberto Rodriguez</b></label>                                
                            </div>

                            <div class="col-xs-12 col-sm-3">                                
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Porcentaje Retorno: <b style="font-size: 14px;">12%</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Precios Desde: <b style="font-size: 14px;">S/. 15</b></label>
                                <label class="col-md-12 control-label" style="text-align: left; padding-left: 0px; padding-right: 0px; font-size: 12px;">Día Límite Pago: <b style="font-size: 14px;">2</b></label>
                            </div>

                            <br><br><br><br><br>
                            <br><br>
                            <br><br><br><br><br>
                        </div>
                        <div class="modal-footer">                                    
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                        -->                        
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
    <script src="../default/assets_acemaster/js/jquery-ui.custom.min.js"></script>
    <script src="../default/assets_acemaster/js/jquery.ui.touch-punch.min.js"></script>
    <script src="../default/assets_acemaster/js/jquery.gritter.min.js"></script>
    <script src="../default/assets_acemaster/js/bootbox.min.js"></script>
    <script src="../default/assets_acemaster/js/jquery.easypiechart.min.js"></script>
    <script src="../default/assets_acemaster/js/bootstrap-datepicker.min.js"></script>
    <script src="../default/assets_acemaster/js/jquery.hotkeys.min.js"></script>
    <script src="../default/assets_acemaster/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../default/assets_acemaster/js/select2.min.js"></script>
    <script src="../default/assets_acemaster/js/fuelux.spinner.min.js"></script>
    <script src="../default/assets_acemaster/js/bootstrap-editable.min.js"></script>
    <script src="../default/assets_acemaster/js/ace-editable.min.js"></script>
    <script src="../default/assets_acemaster/js/jquery.maskedinput.min.js"></script>

    </body>
    </html>
<?php } ?>