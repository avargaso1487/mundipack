<div class="row">
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-green-light">
      <div class="card-body">
        <i class="icon fa fa-shopping-basket fa-4x"></i>
        <div class="content">
          <div class="title">Comisiones</div>
          <div class="value"><span class="sign">S/</span><label id="comisiones"></label></div>
          <!--<div class="value"><span class="sign">S/</span><label id="">0.00</label></div>-->
        </div>
      </div>
    </a>
  </div>
  
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-blue-light" href="../../view/travelers/netPartners.php">
      <div class="card-body">
        <i class="icon fa fa-thumbs-o-up fa-4x"></i>
        <div class="content">
          <div class="title">Net Partners</div>
          <div class="value"><span class="sign"></span><labe id="total_socio"></labe></div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <a class="card card-banner card-yellow-light" href="../../view/travelers/traveler_abiertos.php">
      <div class="card-body">
        <i class="icon fa fa-user fa-4x"></i>
        <div class="content">
          <div class="title">travelers</div>
          <div class="value"><span class="sign"></span><label id="total_viajeros"></label></div>
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
              <th style="text-align: left">MOVIMIENTO</th>
              <th style="text-align: center">TIPO MOVIMIENTO</th>
              <th style="text-align: center">MONTO</th>
              <th style="text-align: center">FECHA MOVIMIENTO</th>
              <th style="text-align: center">ESTADO</th>
            </tr>
          </thead>
          <tbody id="tblMovimientos">

          </tbody>
        </table>
      </div>
    </div>
  </div>