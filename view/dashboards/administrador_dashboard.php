<!--Fila de Comisiones-->
<div class="btn-floating" id="help-actions">
    <div class="btn-bg"></div>
    <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle"
            data-target="#help-actions">
        <i class="icon fa fa-plus"></i>
        <span class="help-text">Shortcut</span>
    </button>
    <div class="toggle-content">
        <ul class="actions">
            <li><a href="../administrador/socios.php">Nuevo Socio</a></li>
            <li><a href="../administrador/viajeros.php">Nuevo Viajero</a></li>

            <li><a href="#" data-toggle="modal" id="addTipoCambio" data-target="#modalTipoCambio">Tipo de
                    Cambio</a></li>
            <li><a href="#" data-toggle="modal" id="addPorcentaje" data-target="#modalPorcentaje">% de
                    Comisiòn</a></li>
        </ul>
    </div>
</div>
<div class="row">
  <!--Cartilla de Comisiones Totales-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-green-light">
      <div class="card-body">
        <i class="icon fa fa-money fa-4x"></i>
        <div class="content">
          <div class="title">Comisiones</div>
          <div class="value"><span class="sign">S/</span><?php echo $_SESSION['mundipackComisiones']; ?></div>
        </div>
      </div>
    </a>
  </div>
  <!--Cartilla de Comisiones de Travelers-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-blue-light"  href="../administrador/socios.php">
      <div class="card-body">
        <i class="icon fa fa-money fa-4x"></i>
        <div class="content">
          <div class="title">Comisiones</div>
          <div class="value"><span class="sign"></span><?php echo $_SESSION['mundipackSocios']; ?></div>
        </div>
      </div>
    </a>
  </div>
  <!--Cartilla de Comisiones de Mundipack-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-yellow-light" href="../administrador/viajeros.php">
      <div class="card-body">
        <i class="icon fa fa-money fa-4x"></i>
        <div class="content">
          <div class="title">Comisiones</div>
          <div class="value"><span class="sign"></span><?php echo $_SESSION['mundipackTravelers']; ?></div>
        </div>
      </div>
    </a>
  </div>
</div>

<!--Fila de Net Partners-->
<div class="row">
  <!--Cartilla de Net Partners Totales-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-green-light">
      <div class="card-body">
        <i class="icon fa fa-home fa-4x"></i>
        <div class="content">
          <div class="title">NET PARTNERS</div>
          <div class="value"><span class="sign">S/</span><?php echo $_SESSION['mundipackComisiones']; ?></div>
        </div>
      </div>
    </a>
  </div>
  <!--Cartilla de Net Partners al día-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-blue-light"  href="../administrador/socios.php">
      <div class="card-body">
        <i class="icon fa fa-home fa-4x"></i>
        <div class="content">
          <div class="title">NET PARTNERS</div>
          <div class="value"><span class="sign"></span><?php echo $_SESSION['mundipackSocios']; ?></div>
        </div>
      </div>
    </a>
  </div>
  <!--Cartilla de Net Partners con deuda-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-yellow-light" href="../administrador/viajeros.php">
      <div class="card-body">
        <i class="icon fa fa-home fa-4x"></i>
        <div class="content">
          <div class="title">NET PARTNERS</div>
          <div class="value"><span class="sign"></span><?php echo $_SESSION['mundipackTravelers']; ?></div>
        </div>
      </div>
    </a>
  </div>
</div>

<!--Fila de Travelers-->
<div class="row">
  <!--Cartilla de Travelers Totales-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-green-light">
      <div class="card-body">
        <i class="icon fa fa-group fa-4x"></i>
        <div class="content">
          <div class="title">TRAVELERS</div>
          <div class="value"><span class="sign">S/</span><?php echo $_SESSION['mundipackComisiones']; ?></div>
        </div>
      </div>
    </a>
  </div>
  <!--Cartilla de Travelers al día-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-blue-light"  href="../administrador/socios.php">
      <div class="card-body">
        <i class="icon fa fa-group fa-4x"></i>
        <div class="content">
          <div class="title">TRAVELERS</div>
          <div class="value"><span class="sign"></span><?php echo $_SESSION['mundipackSocios']; ?></div>
        </div>
      </div>
    </a>
  </div>
  <!--Cartilla de Travelers con deuda-->
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-yellow-light" href="../administrador/viajeros.php">
      <div class="card-body">
        <i class="icon fa fa-group fa-4x"></i>
        <div class="content">
          <div class="title">TRAVELERS</div>
          <div class="value"><span class="sign"></span><?php echo $_SESSION['mundipackTravelers']; ?></div>
        </div>
      </div>
    </a>
  </div>
</div>
<!--
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title">Últimos movimientos</div>
        <ul class="card-action">
          <li>
            <a href="/">
              <i class="fa fa-refresh"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body no-padding table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th>Usuario</th>
              <th class="right">Tipo</th>
              <th>Movimiento</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Juan Carlos</td>
              <td class="right">Viajero</td>
              <td><span class="badge badge-success badge-icon"><i class="fa fa-credit-card" aria-hidden="true"></i><span>Depósito</span></span></td>
            </tr>
            <tr>
              <td>Pollería Rokys</td>
              <td class="right">Socio</td>
              <td><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Nuevo Net Partner</span></span></td>
            </tr>
            <tr>
              <td>Aldo Diego</td>
              <td class="right">Socio</td>
              <td><span class="badge badge-info badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Nuevo Net Partner</span></span></td>
            </tr>
            <tr>
              <td>Alvaro Alfredo</td>
              <td class="right">Viajero</td>
              <td><span class="badge badge-success badge-icon"><i class="fa fa-user-plus" aria-hidden="true"></i><span>Nuevo Traveler</span></span></td>
            </tr>            
          </tbody>
        </table>
      </div>
    </div>
  </div>
-->