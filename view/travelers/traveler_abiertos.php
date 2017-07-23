<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
} else {
    ?>

    <!DOCTYPE html>
    <html lang="ES">
    <head>
        <title>MUNDIPACK | TRAVELER</title>

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
        <link rel="stylesheet" href="../default/assets_acemaster/css/lightbox.css" />

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

                <div class="card">
                    <div class="card-header">
                        <p class="UserNameTitle">Lista de Travelers Expansivos</p>
                    </div>
                    <div>
                        <div class="card-body padding" id="listTravelers">


                        </div>
                    </div>
                    <br><br><br><br><br><br><br><br>
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

        <script src="../default/assets_acemaster/js/jquery.2.1.1.min.js"></script>


        <script src="../default/assets_acemaster/js/jquery.1.11.1.min.js"></script>

        <script type="text/javascript">
            window.jQuery || document.write("<script src='../default/assets_acemaster/js/jquery.min.js'>"+"<"+"/script>");
        </script>


        <script type="text/javascript">
            window.jQuery || document.write("<script src='../default/assets_acemaster/js/jquery1x.min.js'>"+"<"+"/script>");
        </script>


        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='../default/assets_acemaster/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>
        <script src="../default/assets_acemaster/js/bootstrap.min.js"></script>


        <script type="text/javascript" src="../default/assets/js/vendor.js"></script>
        <script type="text/javascript" src="../default/assets/js/app.js"></script>

        <script src="../default/js/iziToast.min.js"></script>
        <script src="../default/js/traveler_abierto.js"></script>
        <script src="../default/js/validaciones.js"></script>


        <script src="../default/assets_acemaster/js/lightbox.js"></script>


        <script src="../default/assets_acemaster/js/bootbox.min.js"></script>


        <!-- ace scripts -->
        <script src="../default/assets_acemaster/js/ace-elements.min.js"></script>
        <script src="../default/assets_acemaster/js/ace.min.js"></script>

    </body>
    </html>

<?php } ?>