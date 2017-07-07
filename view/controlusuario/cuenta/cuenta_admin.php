<?php 
  session_start();
  if (!isset($_SESSION['usuario']))
  {
    header("Location:view/controlusuario/login.php");
  } else {
?>

<!DOCTYPE html>
<html>
<head>
  <title>MUNDIPACK | Cuenta</title>

  <meta http-equiv="Content-Type" content="IE=Edge; chrome=1"> 
  <meta charset="UTF-8"">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="../../../assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../../../assets/css/flat-admin.css">

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="../../../assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="../../../assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="../../../assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="../../../assets/css/theme/yellow.css">

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


  <div class="sidebar-menu" id="tree">


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
<nav class="navbar navbar-default" id="navbar">
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
            <img class="profile-img" src="../../../assets/images/profile.jpg">
          </button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title">Cuenta Administrador</li>
        <!-- Search 
        <li class="navbar-search hidden-sm">
          <input id="search" type="text" placeholder="Search..">
          <button class="btn-search"><i class="fa fa-search"></i></button>
        </li> -->
      </ul>

      
      <!-- Menús despegables -->

      <ul class="nav navbar-nav navbar-right">

      <!--
        <li class="dropdown notification">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
            <div class="title">New Orders</div>
            <div class="count">0</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Ordering</li>
              <li class="dropdown-empty">No New Ordered</li>
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>

        

        <li class="dropdown notification warning">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-comments" aria-hidden="true"></i></div>
            <div class="title">Unread Messages</div>
            <div class="count">99</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Message</li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">10</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Payment Confirmation.."</div>
                      <div class="description">Alan Anderson</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">5</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Hello World"</div>
                      <div class="description">Marco  Harmon</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">2</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Order Confirmation.."</div>
                      <div class="description">Brenda Lawson</div>
                    </div>
                  </div>
                </a>
              </li>
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>
        <li class="dropdown notification danger">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
            <div class="title">System Notifications</div>
            <div class="count">10</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Notification</li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">8</span>
                  <div class="message">
                    <div class="content">
                      <div class="title">New Order</div>
                      <div class="description">$400 total</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">14</span>
                  Inbox
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">5</span>
                  Issues Report
                </a>
              </li>
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>

        -->


        <li class="dropdown profile">
          <a href="/html/pages/profile.html" class="dropdown-toggle"  data-toggle="dropdown">
            <img class="profile-img" src="../guardar/<?php echo $_SESSION['usuarioImagen'];?>" >
            <div class="title">Profile</div>
          </a>
          <div class="dropdown-menu">
            <div class="profile-info">
              <h4 class="username"><?php echo $_SESSION['usuarioNombre']; ?></h4>
            </div>
            <ul class="action">
              <li>
                <a href="cuenta_admin.php">
                  Cuenta
                </a>
              </li>
              <li>
                <a href="../../../view/controlusuario/logout.php">
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

  <!-- <div class="btn-floating" id="help-actions">
  <div class="btn-bg"></div>
  <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle" data-target="#help-actions">
    <i class="icon fa fa-plus"></i>
    <span class="help-text">Shortcut</span>
  </button>
  <div class="toggle-content">
    <ul class="actions">
      <li><a href="#">Nuevo Socio</a></li>
      <li><a href="#">Nuevo Viajero</a></li>
    </ul>
  </div>
</div> -->

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

    
    <div class="col-md-12">
      <div class="card">
      
        <div class="card-header">
          Información del Usuario
        </div>
        <div class="card-body">
          <form class="form form-horizontal" method="post" enctype="multipart/form-data" action="../guardar/subir_imagen.php">
            <div class="section">
              <div class="section-title">Datos Personales</div>
              <div class="section-body">

                <!-- Nombres -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Nombres</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Nombres">
                  </div>
                </div>

                <!-- Apellidos -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Apellido Paterno</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Apellido Paterno">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label">Apellido Materno</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Apellido Materno">
                  </div>
                </div>

                <!-- Radio Button Sexo -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Sexo</label>
                  <div class="col-md-9">
                    <div class="radio radio-inline">
                        <input type="radio" name="radio4" id="radio10" value="option10">
                        <label for="radio10">
                          Masculino
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <input type="radio" name="radio4" id="radio11" value="option11" checked>
                        <label for="radio11">
                          Femenino
                        </label>
                    </div>
                  </div>
                </div>

                <!-- Correo Eléctronico -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Correo Electrónico</label>
                  <div class="col-md-9">
                    <input type="email" class="form-control" placeholder="E-mail" >
                  </div>
                </div>

                <!-- Celular -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Celular</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Celular">
                  </div>
                </div>

                <!-- DNI - Carnet de Extranjería -->
                <div class="form-group">
                  <label class="col-md-3 control-label">DNI - Carnet de Extranjería</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="DNI/Carnet de Extranjería">
                  </div>
                </div>

                <!-- Dirección -->
                <div class="form-group">
                  <div class="col-md-3">
                    <label class="control-label">Dirección</label>
                    <p class="control-label-help">( Calle/Urbanización/Departamento, Distrito )</p>
                  </div>
                  <div class="col-md-9">
                    <textarea class="form-control"></textarea>
                  </div>
                </div>

                <!-- Ciudad -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Ciudad</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="Ciudad">
                  </div>
                </div>

                <!-- <div class="form-group">
                  <div class="col-md-3">
                    <label class="control-label">Description</label>
                    <p class="control-label-help">( short detail of products , 150 max words )</p>
                  </div>
                  <div class="col-md-9">
                    <textarea class="form-control"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Price</label>
                  <div class="col-md-9">
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                    </div>
                  </div>
                </div> -->


              </div>
            </div>

            <div class="section">
              <div class="section-title">Datos de Usuario</div>
              <div class="section-body">
                
                <!-- Usuario -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Usuario</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" placeholder="">
                  </div>
                </div>

                <!-- Cambiar imagen de cuenta -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Perfil de cuenta</label>
                  <div class="col-md-9">
                    <input class="form-control" type="file" name="foto">
                  </div>
                </div>

                <!-- Anterior Contraseña -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Contraseña Anterior</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" placeholder="">
                  </div>
                </div>

                <!-- Nueva Contraseña -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Nueva Contraseña</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" placeholder="Nueva contraseña">
                  </div>
                </div>

                 <!-- Repetir Nueva Contraseña -->
                <div class="form-group">
                  <label class="col-md-3 control-label">Repetir nueva contraseña</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" placeholder="Repetir nueva contraseña">
                  </div>
                </div>

                <!--
                <div class="form-group">
                  <label class="col-md-3 control-label">Cover</label>
                  <div class="col-md-4">
                    <div class="input-group">
                      <select class="select2">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                      </select>
                      <span class="input-group-addon">Years</span>
                    </div>
                  </div>
                </div> -->


              </div>
            </div>
            <div class="form-footer">
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button type="button" class="btn btn-default">Cancelar</button>
                </div>
              </div>
            </div>
        </form>
        </div>

      </div>
    </div>
<!-- pIE cHART
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="card card-tab card-mini">
      <div class="card-header">
        <ul class="nav nav-tabs tab-stats">
          <li role="tab1" class="active">
            <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Browsers</a>
          </li>
          <li role="tab2">
            <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">OS</a>
          </li>
          <li role="tab2">
            <a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">More</a>
          </li>
        </ul>
      </div>
      <div class="card-body tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab1">
          <div class="row">
            <div class="col-sm-8">
              <div class="chart ct-chart-browser ct-perfect-fourth"></div>
            </div>
            <div class="col-sm-4">
              <ul class="chart-label">
                <li class="ct-label ct-series-a">Google Chrome</li>
                <li class="ct-label ct-series-b">Firefox</li>
                <li class="ct-label ct-series-c">Safari</li>
                <li class="ct-label ct-series-d">IE</li>
                <li class="ct-label ct-series-e">Opera</li>
              </ul>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tab2">
          <div class="row">
            <div class="col-sm-8">
              <div class="chart ct-chart-os ct-perfect-fourth"></div>
            </div>
            <div class="col-sm-4">
              <ul class="chart-label">
                <li class="ct-label ct-series-a">iOS</li>
                <li class="ct-label ct-series-b">Android</li>
                <li class="ct-label ct-series-c">Windows</li>
                <li class="ct-label ct-series-d">OSX</li>
                <li class="ct-label ct-series-e">Linux</li>
              </ul>
            </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tab3">
        </div>
      </div>
    </div>
  </div>
</div>

-->

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
  
    <script type="text/javascript" src="../../../assets/js/vendor.js"></script>
    <script type="text/javascript" src="../../../assets/js/app.js"></script>

    <script src="../../../assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <script src="../../../js/treemodulo.js"></script>
   <!-- jQuery 2.1.4 -->
    <script src="../../../assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Sparkline -->
    <script src="../../../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../../../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../../../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../../assets/plugins/knob/jquery.knob.js"></script>
   

    
    <script type="text/javascript">
      $(function () {
        $('#example').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });

      function solonumeros(e) {
            key = e.keyCode || e.which;
            teclado = String.fromCharCode(key);
            numeros = "0123456789";
            especiales = "8-37-38-46"
            teclado_especial=false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    teclado_especial= true;
                }
            }

            if (numeros.indexOf(teclado)==-1 && !teclado_especial) {
                return false;
            }
        }

        function telefonovalidation(e) {
            var unicode = e.charCode ? e.charCode : e.keyCode            
            if (unicode != 45 && unicode != 32) {
                if (unicode < 48 || unicode > 57) //if not a number
                { return false } //disable key press                
            }
        }

    </script>

</body>
</html>

<?php } ?>