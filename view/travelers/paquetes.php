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
        <title>MUNDIPACK | TRAVELER</title>

        <meta http-equiv="Content-Type" content="IE=Edge; chrome=1">
        <meta charset="UTF-8"">
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
                            Paquetes Ofrecidos
                        </div>
                        <!--div class="card-body padding">
                            <table class="table-responsive datatable table table-striped primary" cellspacing="0" width="100%" id="tblVentasReg">
                                <thead>
                                <tr>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 15%;">Nª de Orperación</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 10%;">Monto Couta</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Fecha Pago</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Estado</th>
                                </tr>
                                </thead>

                                <tbody id="cuerpoTablaVentasReg">


                                </tbody>
                            </table>

                        </div-->
                        <br><br><br><br><br><br><br><br>
                        <br><br><br><br><br><br><br><br>
                        <br><br><br><br><br><br><br><br>
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
    <script src="../default/js/pagos_traveler.js"></script>
    <script src="../default/js/iziToast.min.js"></script>

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