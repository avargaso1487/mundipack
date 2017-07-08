<div class="btn-floating" id="help-actions">
    <div class="btn-bg"></div>
    <button type="button" class="btn btn-default btn-toggle" data-toggle="toggle"
            data-target="#help-actions">
        <i class="icon fa fa-plus"></i>
        <span class="help-text">Shortcut</span>
    </button>
    <div class="toggle-content">
        <ul class="actions">
            <li><a href="#" data-toggle="modal" data-target="#modalVenta" id="new_venta">Nueva Venta</a></li>
        </ul>
    </div>
</div>
<div class="row">
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-green-light">
      <div class="card-body">
        <i class="icon fa fa-shopping-basket fa-4x"></i>
        <div class="content">
          <div class="title">Total de Ventas Realizadas</div>
          <div class="value" id="totalVentasSocio"><span class="sign"></span></div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-blue-light">
      <div class="card-body">
        <i class="icon fa fa-usd fa-4x"></i>
        <div class="content">
          <div class="title">Monto Total de Ventas</div>
          <div class="value" id="montoTotalVentasSocio"><span class="sign"></span></div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-yellow-light">
      <div class="card-body">
        <i class="icon fa fa-user fa-4x"></i>
        <div class="content">
          <div class="title">Total de Travelers</div>
          <div class="value" id="nroSocios"><span class="sign"></span></div>
        </div>
      </div>
    </a>
  </div>  
</div>

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
              <th>Cliente</th>
              <th>T. Documento</th>
              <th>Documento</th>
              <th>Importe</th>
              <th>F. Documento</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody id="ultimosMovimientos">

          </tbody>
        </table>
      </div>
    </div>
  </div>