<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../../index.php");
} else {
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>MUNDIPACK | Dashboard</title>

        <meta http-equiv="Content-Type" content="IE=Edge; chrome=1">
        <meta charset="UTF-8"
        ">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="../default/assets/css/vendor.css">
        <link rel="stylesheet" type="text/css" href="../default/assets/css/flat-admin.css">

        <!-- Theme -->

        <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/blue-sky.css">
        <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/blue.css">
        <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/red.css">
        <link rel="stylesheet" type="text/css" href="../default/assets/css/theme/yellow.css">
        <link rel="stylesheet" href="../default/assets/css/jquery.gritter.min.css"/>

    </head>
    <body>
    <div class="app app-default">

        <aside class="app-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="../principal/principal_admin.php"><span class="highlight">MUNDI</span>PACK</a>
                <button type="button" class="sidebar-toggle">
                    <i class="fa fa-times"></i>
                </button>
            </div>


            <!-- Sidebar Menu -->


            <div class="sidebar-menu" id="permisos">


                <!-- Sidebar Menu

                  <div class="sidebar-menu">
                    <ul class="sidebar-nav">
                      <li class="active">
                        <a href="./principal.php">
                          <div class="icon">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                          </div>
                          <div class="title">Dashboard</div>
                        </a>
                      </li>
                      <li class="@@menu.messaging">
                        <a href="./messaging.html">
                          <div class="icon">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                          </div>
                          <div class="title">Messaging</div>
                        </a>
                      </li>
                      <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <div class="icon">
                            <i class="fa fa-check" aria-hidden="true"></i>
                          </div>
                          <div class="title">UI Kits</div>
                        </a>
                        <div class="dropdown-menu">
                          <ul>
                            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> UI Kits</li>
                            <li><a href="./uikits/customize.html">Customize</a></li>
                            <li><a href="./uikits/components.html">Components</a></li>
                            <li><a href="./uikits/card.html">Card</a></li>
                            <li><a href="./uikits/form.html">Form</a></li>
                            <li><a href="./uikits/table.html">Table</a></li>
                            <li><a href="./uikits/icons.html">Icons</a></li>
                            <li class="line"></li>
                            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Advanced Components</li>
                            <li><a href="./uikits/pricing-table.html">Pricing Table</a></li>
                            <li><a href="./uikits/timeline.html">Timeline</a></li>
                            <li><a href="./uikits/chart.html">Chart</a></li>
                          </ul>
                        </div>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <div class="icon">
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                          </div>
                          <div class="title">Pages</div>
                        </a>
                        <div class="dropdown-menu">
                          <ul>
                            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Admin</li>
                            <li><a href="./pages/form.html">Form</a></li>
                            <li><a href="./pages/profile.html">Profile</a></li>
                            <li><a href="./pages/search.html">Search</a></li>
                            <li class="line"></li>
                            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Landing</li>
                            <li><a href="./pages/landing.html">Landing</a></li>
                            <li><a href="./pages/login.html">Login</a></li>
                            <li><a href="./pages/register.html">Register</a></li>
                            <li><a href="./pages/404.html">404</a></li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>

                -->

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
                            <li class="navbar-title">Dashboard <?php echo $_SESSION['usuarioDashboard']; ?></li>
                            <!-- Search
                            <li class="navbar-search hidden-sm">
                              <input id="search" type="text" placeholder="Search..">
                              <button class="btn-search"><i class="fa fa-search"></i></button>
                            </li> -->
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

            <input type="hidden" dissabled="true" value="Dashboard" id="Menu">


            <!-- Gráfico
            <div class="row">
              <div class="col-xs-12">
                <div class="card card-banner card-chart card-green no-br">
                  <div class="card-header">
                    <div class="card-title">
                      <div class="title">Top Sale Today</div>
                    </div>
                    <ul class="card-action">
                      <li>
                        <a href="/">
                          <i class="fa fa-refresh"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="ct-chart-sale"></div>
                  </div>
                </div>
              </div>
            </div>

            -->

            <?php
            include("../dashboards/" . $_SESSION['usuarioDashboardURL']);
            ?>

            <div class="modal fade" id="modalTipoCambio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Tipo de Cambio (Actual)</h4>
                        </div>

                        <div class="modal-body">
                            <form class="form form-horizontal" method="post" id="frm_nuevoSocio"
                                  style="font-size: 12px;">
                                <!-- Precio Compra -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Precio Compra</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Precio Compra"
                                               name="txtxPrecioCompra" id="txtxPrecioCompra">
                                    </div>
                                </div>

                                <!-- Precio Venta -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Precio Venta</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Precio Venta"
                                               name="txtxPrecioVenta" id="txtxPrecioVenta">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12 control-label" id="mensaje"></label>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar
                                    </button>
                                    <input style="display:none;" type="button" id="guardarTipoCambio"
                                           class="btn btn-sm btn-primary" data-dismiss="modal" value="Guardar"/>
                                    <input style="display:none;" type="button" id="editarTipoCambio"
                                           data-dismiss="modal"
                                           class="btn btn-sm btn-primary" value="Modificar"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPorcentaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="titulo"></h4>
                        </div>

                        <div class="modal-body">
                            <div id="divRegistro" style="display: none">
                                <form class="form form-horizontal" method="post" id="frm_nuevoSocio"
                                      style="font-size: 12px;">
                                    <!-- (%) Comisión -->
                                    <div class="form-group">
                                        <div class="col-md-2"></div>
                                        <label class="col-md-3 control-label">(%) Comisiòn</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" placeholder="% Comisión"
                                                   name="txtxPorcentaje" id="txtxPorcentaje">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <input style="display:none;" type="button" id="guardarPorcentaje"
                                               class="btn btn-sm btn-primary" data-dismiss="modal" value="Guardar"/>
                                    </div>
                                </form>
                            </div>

                            <div id="divObservacion" style="display: none">
                                <div class="form form-horizontal">
                                    <div id="mensaje2"></div>
                                </div>
                                <br><br>

                                <input type="hidden" class="form-control"
                                       name="txtValor" id="txtValor">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <input style="display:none;" type="button" id="newPorcentaje"
                                           class="btn btn-sm btn-primary" value="Nuevo"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" style="width: 60% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Registrar Nueva Venta</h4>

                        </div>

                        <div class="modal-body">
                            <form class="form form-horizontal" method="post" id="frm_nuevoSocio"
                                  style="font-size: 12px;">
                                <!-- DNI -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">DNI <span style="color: red">(*)</span></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="Dni" name="ventaDni"
                                               maxlength="8" id="ventaDni" onkeypress="return solonumeros(event)">
                                    </div>
                                    <div class="col-md-3">
                                        <butotn id="searchSocio" class="btn btn-success btn-xs"><i
                                                    class="fa fa-search"></i></butotn>
                                    </div>
                                </div>

                                <!-- CLIENTE -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Cliente</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Cliente"
                                               name="ventaCliente" id="ventaCliente" disabled="disabled">
                                        <input type="hidden" class="form-control" placeholder="Cliente"
                                               name="ventaClienteId" id="ventaClienteId" disabled="disabled">
                                    </div>
                                </div>

                                <!-- Tipo Documento -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">T. Documento <span style="color: red">(*)</span></label>
                                    <div class="col-md-5" id="divTipDoc">

                                    </div>
                                </div>

                                <br>

                                <!-- Documento -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Documento <span style="color: red">(*)</span></label>
                                    <div class="col-md-9">
                                        <div class="col-md-2">
                                            <input type="text" class="form-control"
                                                   onkeypress="return solonumeros(event)" placeholder="Serie"
                                                   name="ventaSerie" id="ventaSerie">
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control"
                                                   onkeypress="return solonumeros(event)" placeholder="Número"
                                                   name="ventaNumero" id="ventaNumero">
                                        </div>
                                    </div>
                                </div>

                                <!-- Importe y Fecha -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Importe <span style="color: red">(*)</span></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="Importe"
                                               name="ventaImporte" id="ventaImporte"
                                               onkeypress="return NumCheck(event, this)"/>
                                    </div>
                                    <label class="col-md-1 control-label">Fecha <span style="color: red">(*)</span></label>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" placeholder="F. Transaccion"
                                               name="ventaFecha" id="ventaFecha">
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
                                    <input type="button" id="guardarVenta" data-dismiss="modal"
                                           class="btn btn-sm btn-primary" value="Guardar"/>
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

    <script src="../default/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../default/assets/js/jquery.gritter.min.js"></script>
    <script src="../default/js/dashboard.js"></script>
    <script src="../default/js/validaciones.js"></script>
    <script>
        dashboard.init();
    </script>
    </body>
    </html>

<?php } ?>