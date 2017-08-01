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
                            <li class="dropdown notification danger hidden" id="pago_traveler">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <div class="icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
                                    <div class="title">New Orders</div>
                                    <div class="count" id="noti_pago_traveler">1</div>
                                </a>
                                <div class="dropdown-menu">
                                    <ul id="item_pago_traveler">
                                    </ul>
                                </div>
                            </li>

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

            <input type="hidden" dissabled="true" value="Gestion Financiera" id="Menu">

            <div class="btn-floating" id="help-actions">
                <div class="btn-bg"></div>
                <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle" data-target="#help-actions">
                    <i class="icon fa fa-plus"></i>
                    <span class="help-text">Shortcut</span>
                </button>
                <div class="toggle-content">
                    <ul class="actions">
                        <li>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalVenta" id="new_venta">Pre Registro de Consumo</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            Listado de Consumos
                        </div>
                        <div class="card-body padding">
                            <table class="table-responsive datatable table table-striped primary" cellspacing="0" width="100%" id="tblVentasReg">
                                <thead>
                                <tr>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 15%;">Net Partner</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 10%;">Tipo Documento</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Documento</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Importe</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Fecha Documento</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 8%;">Estado</th>
                                    <th style="font-size: 12px; text-align: center; height: 10px; width: 5%;">Operaciones</th>
                                </tr>
                                </thead>

                                <tbody id="cuerpoTablaVentasReg">
                                

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="modalVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width: 60% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="titulo"></h4>

                        </div>

                        <div class="modal-body">
                            <form class="form form-horizontal" method="post" id="frm_nuevoSocio" style="font-size: 12px;">

                                <!-- SOCIO -->
                                <!--div class="form-group">
                                    <label class="col-md-2 control-label">Net Partners <span style="color: red">(*)</span></label>
                                    <div class="col-md-5" id="divSocio">

                                    </div>
                                </div-->

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Net Partners <span style="color: red">(*)</span></label>
                                    <div class="col-md-5" id="divSocio">

                                    </div>
                                </div>
                                <br>
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
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" onkeypress="return solonumeros(event)" placeholder="Serie"  name="ventaSerie" id="ventaSerie" maxlength="5">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" onkeypress="return solonumeros(event)" placeholder="Número"  name="ventaNumero" id="ventaNumero" maxlength="7">
                                    </div>
                                </div>




                                <input type="hidden" class="form-control"  placeholder="Importe"  name="transaccionID" id="transaccionID" onkeypress="return NumCheck(event, this)"/>
                                <!-- Importe y Fecha -->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Importe <span style="color: red">(*)</span></label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control"  placeholder="Importe"  name="ventaImporte" id="ventaImporte" onkeypress="return SoloNumerosDecimales3(event, '0.0', 6, 2);"/>
                                    </div>
                                    <label class="col-md-2 control-label">Fecha <span style="color: red">(*)</span></label>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" placeholder="F. Transaccion"  name="ventaFecha" id="ventaFecha">
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label class="col-md-12 control-label" style="color: red">(*) Los campos son obligatorios.</label>
                                </div>
                                <br>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                                    <input  type="button" id="guardarVenta" class="btn btn-sm btn-primary" value="Guardar"/>
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
    <script src="../default/js/traveler_pre_registro.js"></script>
    <script src="../default/js/iziToast.min.js"></script>

    <script src="../default/js/validaciones.js"></script>


    <script src="../default/assets_acemaster/js/chosen.jquery.min.js"></script>
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
    <script type="text/javascript">
        jQuery(function($) {

            if(!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect:true});
                //resize the chosen on window resize

                $(window)
                    .off('resize.chosen')
                    .on('resize.chosen', function() {
                        $('.chosen-select').each(function() {
                            var $this = $(this);
                            $this.next().css({'width': '300px'});
                        })
                    }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                    if(event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({'width': '300px'});
                    })
                });


                $('#chosen-multiple-style .btn').on('click', function(e){
                    var target = $(this).find('input[type=radio]');
                    var which = parseInt(target.val());
                    if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
                    else $('#form-field-select-4').removeClass('tag-input-style');
                });
            }

        });
    </script>
    </body>
    </html>

<?php } ?>