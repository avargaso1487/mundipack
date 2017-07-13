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

        <link rel="stylesheet" href="../default/assets_acemaster/font-awesome/4.2.0/css/font-awesome.min.css"/>

        <!-- page specific plugin styles -->
        <link rel="stylesheet" href="../default/assets_acemaster/css/jquery-ui.custom.min.css"/>
        <link rel="stylesheet" href="../default/assets_acemaster/css/jquery.gritter.min.css"/>
        <link rel="stylesheet" href="../default/assets_acemaster/css/select2.min.css"/>
        <link rel="stylesheet" href="../default/assets_acemaster/css/datepicker.min.css"/>
        <link rel="stylesheet" href="../default/assets_acemaster/css/bootstrap-editable.min.css"/>

        <link rel="stylesheet" href="../default/assets_acemaster/fonts/fonts.googleapis.com.css"/>

        <script src="../default/assets_acemaster/js/ace-extra.min.js"></script>

        <link rel="stylesheet" href="../default/assets_acemaster/css/ace.min.css" class="ace-main-stylesheet"
              id="main-ace-style"/>

        <script src="../default/assets_acemaster/js/ace-extra.min.js"></script>

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
            <nav class="navbarflat navbar-default" id="navbar" style="background-color: transparent;">
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
                            <li class="dropdown notification danger hidden" id="ventas_pre_registradas">
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
                                            <a href="perfil.php">
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

            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="UserNameTitle" id="netpartner_nombrecomercial">Perfil
                                de <?php echo $_SESSION['usuarioNombres']; ?></p>
                        </div>
                        <div class="card-body padding">
                            <div id="user-profile-1" class="user-profile row">
                                <div class="col-xs-12 col-sm-1">
                                </div>
                                <div class="col-xs-12 col-sm-3 center">
                                    <div>
                                          <span class="profile-img" id="imagen">

                                          </span>
                                        <div class="space-4"></div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="profile-user-info profile-user-info-striped">
                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Razón Social</div>
                                            <div class="profile-info-value">
                                                <!--Valor se reemplaza esde modelo-->
                                                <span id="netpartner_RazonSocial"></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> RUC</div>

                                            <div class="profile-info-value">
                                                <span id="netpartner_Ruc"></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Nombre Comercial</div>

                                            <div class="profile-info-value">
                                                <span id="netpartner_Comercial"></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Rubro</div>

                                            <div class="profile-info-value">
                                                <span id="netpartner_Rubro"></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Dirección</div>

                                            <div class="profile-info-value">
                                                <span id="netpartner_Direccion"></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> Email</div>

                                            <div class="profile-info-value">
                                                <span id="netpartner_Email"></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> T. Contacto</div>

                                            <div class="profile-info-value">
                                                <span id="netpartner_Contacto"></span>
                                            </div>
                                        </div>

                                        <div class="profile-info-row">
                                            <div class="profile-info-name"> T. Atención</div>

                                            <div class="profile-info-value">
                                                <span id="netpartner_Atencion"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="col-xs-12">
                                        <input  type="button" id="editarPerfil"
                                                class="btn btn-sm btn-primary" value="Editar Perfil"/>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>


                <!-- MODAL UPDATE PERFIL-->

                <div class="modal fade" id="modalPerfilModificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Modificar Perfil</h4>

                            </div>

                            <div class="modal-body">

                                <div id="mensaje" class="col-md-12"></div>
                                <form class="form form-horizontal" method="post" id="frm_updatePerfil"
                                      style="font-size: 12px;">

                                    <!-- Telefono -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Teléfono</label>
                                        <div class="col-md-9">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                       onkeypress="return solonumeros(event)" placeholder="Contacto"
                                                       name="p_contacto" id="p_contacto">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control"
                                                       onkeypress="return solonumeros(event)" placeholder="Atención"
                                                       name="p_atencion" id="p_atencion">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9">
                                            <div class="col-md-12">
                                                <input type="password" class="form-control" placeholder="Password"
                                                       name="p_paswword" id="p_paswword">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Foto Perfil</label>
                                        <div class="col-md-9">
                                            <div class="col-md-12">
                                                <input type="file" name="p_imagenPerfil" id="p_imagenPerfil">
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Carta Presentacion</label>
                                        <div class="col-md-9">
                                            <div class="col-md-12">
                                                <input type="file" name="p_imagenCarta" id="p_imagenCarta">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar
                                        </button>
                                        <input  type="button" id="modificarPerfil"
                                                class="btn btn-sm btn-primary" value="Guardar"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- MODAL CONFIRMACION UPDATE PERFIL-->
                <div class="modal fade" id="modalPerfilConfirmacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" style="color: red; font-size: 16px; text-align: center;">Mensaje de Confirmación</h4>
                            </div>

                            <div class="modal-body">

                                <div id="mensaje" class="col-md-12"></div>
                                <form class="form form-horizontal" method="post"
                                      style="font-size: 12px;">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label" style="text-align: center; font-size: 14px;">Los cambios se realizaron correctamente, por favor inicie sesión nuevamente.</label>
                                    </div>
                                    <br><br>
                                    <div class="modal-footer">
                                        <input  type="button" id="confirmarCambios"
                                                class="btn btn-sm btn-danger" value="OK"/>

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
        <script src="../default/js/ventas.js"></script>
        <script src="../default/js/iziToast.min.js"></script>
        <script src="../default/js/perfil_socio.js"></script>
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

        <!-- ace scripts -->
        <script src="../default/assets_acemaster/js/ace-elements.min.js"></script>
        <script src="../default/assets_acemaster/js/ace.min.js"></script>
    </body>
    </html>

<?php } ?>