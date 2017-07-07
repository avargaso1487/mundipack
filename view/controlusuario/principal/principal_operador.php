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
  <title>MUNDIPACK | Dashboard</title>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="../../default/assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../../default/assets/css/flat-admin.css">

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="../../default/assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="../../default/assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="../../default/assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="../../default/assets/css/theme/yellow.css">

</head>
<body>
  <div class="app app-default">

<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-brand" href="principal_operador.php"><span class="highlight">MUNDI</span>PACK</a>
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


  <div class="btn-floating" id="help-actions">
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
</div>

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
  
    <script type="text/javascript" src="../../default/assets/js/vendor.js"></script>
    <script type="text/javascript" src="../../default/assets/js/app.js"></script>

    <script src="../../default/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <script src="../../js/treemodulo.js"></script>
   <!-- jQuery 2.1.4 -->
    <script src="../../default/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Sparkline -->
    <script src="../../default/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../../default/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../../default/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../default/assets/plugins/knob/jquery.knob.js"></script>
   



</body>
</html>

<?php } ?>