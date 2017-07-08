<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
} else {
    ?>

    <!DOCTYPE html>
    <html lang="ES">
    <head>
        <title>MUNDIPACK | Administrador</title>

        <meta http-equiv="Content-Type" content="IE=Edge; chrome=1">
        <meta charset="UTF-8"
        ">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="../default/assets/css/vendor.css">
        <link rel="stylesheet" type="text/css" href="../default/css/estrellas.css">
        <link rel="stylesheet" type="text/css" href="../default/assets/css/flat-admin.css">
        <link rel="stylesheet" type="text/css" href="../default/css/sweetalert.css">
        <link rel="stylesheet" type="text/css" href="../default/css/iziToast.min.css">

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
                            <li class="dropdown notification danger">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <div class="icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
                                    <div class="title">New Orders</div>
                                    <div class="count" id="noti_ventas_pre_registradas"></div>
                                </a>
                                <div class="dropdown-menu">
                                    <ul id="item_noti">



                                    </ul>
                                </div>
                            </li>
                            <li class="dropdown profile">
                                <a href="/html/pages/profile.html" class="dropdown-toggle" data-toggle="dropdown">
                                    <img class="profile-img" src="../../<?php echo $_SESSION['usuarioImagen']; ?>">
                                    <div class="title">Profile</div>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="profile-info">
                                        <h4 class="username"><?php echo $_SESSION['usuarioNombres']; ?></h4>
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
                <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle"
                        data-target="#help-actions">
                    <i class="icon fa fa-plus"></i>
                    <span class="help-text">Shortcut</span>
                </button>
                <div class="toggle-content">
                    <ul class="actions">
                        <li>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOferta"
                                    id="new_oferta">Nueva OFERTA
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            Lista de Ofertas Registradas
                        </div>
                        <div class="card-body padding">
                            <table class="table-responsive datatable table table-striped primary" cellspacing="0"
                                   width="100%" id="tblOfertas">
                                <thead>
                                <tr>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Descripción</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">F. Inicio</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">F. Fin</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Imagen</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Porcentaje</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 4%;">Estado</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 2%;">Operaciones</th>
                                </tr>
                                </thead>

                                <tbody id="cuerpoTablaOfertas">
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


            <!-- MODAL REGISTRO Y EDITAR-->
            <div class="modal fade" id="modalOferta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width: 60% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Nueva OFERTA</h4>

                        </div>

                        <div class="modal-body">
                            <form class="form form-horizontal" method="post" id="frm_nuevoOferta"
                                  style="font-size: 12px;">

                                <!-- Descripción -->
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label class="control-label">Descripción <span style="color: red">(*)</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="p_descripcion" placeholder="Descripción"
                                                  id="p_descripcion"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control"
                                       placeholder="F. Inicio"
                                       name="p_codigo" id="p_codigo">
                                <!-- Duraciòn -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">F. Inicio <span style="color: red">(*)</span></label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control"
                                               placeholder="F. Inicio"
                                               name="p_fechaInicio" id="p_fechaInicio">
                                    </div>
                                    <label class="col-md-2 control-label">F. Fin <span style="color: red">(*)</span></label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control"
                                               placeholder="F. Fin"
                                               name="p_fechaFin" id="p_fechaFin">
                                    </div>
                                </div>

                                <!-- Stock  y Porcentaje-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Stock</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" onkeypress="return solonumeros(event)"
                                               placeholder="Stock"
                                               name="p_stock" id="p_stock">
                                    </div>

                                    <div class="col-md-4">
                                        <div class="checkbox">
                                            <input type="checkbox" id="p_porcentaje">
                                            <label for="p_porcentaje">
                                                ¿Incluye Porcentaje?
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Imagen -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Imagen</label>
                                    <div class="col-md-10">
                                        <input type="file" placeholder="Imagen"
                                               name="p_imagen" id="p_imagen">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="col-md-12 control-label" style="color: red">(*) Los campos son obligatorios.</label>
                                </div>
                                <br>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar
                                    </button>
                                    <input  type="button" id="guardarOferta"
                                           class="btn btn-sm btn-primary" value="Guardar"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL VER OFERTA-->
            <div class="modal fade" id="modalVerOferta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width: 60% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">DETALLES OFERTA</h4>

                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="card">
                                        <div class="card-body padding">
                                            <div id="user-profile-1" class="user-profile row">
                                                <div class="col-xs-12 col-sm-5 center">
                                                    <div>
                                                          <span class="profile-img" id="imagen">

                                                          </span>
                                                        <div class="space-4"></div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-7">
                                                    <div class="profile-user-info profile-user-info-striped">
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"><strong>Descripción: </strong> <span id="descripcion"></span></div>
                                                        </div>
                                                        <br>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"><strong>F. Inicio: </strong> <span  id="fechaInicio"></span></div>
                                                        </div>
                                                        <br>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"><strong>F. Fin: </strong> <span  id="fechaFin"></span></div>
                                                        </div>
                                                        <br>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"><strong>Stock: </strong> <span  id="stock"></span></div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar
                                </button>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="app-footer">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="footer-copyright">
                            SodaTech+ © 2017 MUNDIPACK
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>

    <script type="text/javascript" src="../default/assets/js/vendor.js"></script>
    <script type="text/javascript" src="../default/assets/js/app.js"></script>
    <script type="text/javascript" src="../default/js/sweetalert.min.js"></script>
    <script src="../default/js/ofertas.js"></script>

    <script src="../default/js/validaciones.js"></script>

    <script src="../default/js/iziToast.min.js"></script>
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

    <!-- ace scripts -->
    <script src="../default/assets_acemaster/js/ace-elements.min.js"></script>
    <script src="../default/assets_acemaster/js/ace.min.js"></script>
    </body>
    </html>

<?php } ?>