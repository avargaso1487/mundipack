<?php 
  session_start();
  if (isset($_SESSION['usuario']))
  {        
    header("Location: view/dashboard/index.php");
  } else {
?>

<!DOCTYPE html>
<html>
<head>
  <title>MUNDIPACK | Log in</title>
  
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="view/default/assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="view/default/assets/css/flat-admin.css">

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="view/default/assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="view/default/assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="view/default/assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="view/default/assets/css/theme/yellow.css">  

</head>
<body>
  <div class="app app-default">

<div class="app-container app-login">
  <div class="flex-center">
    <div class="app-header"></div>

    <div class="app-body">

      <div class="loader-container text-center">

          <div class="icon">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
              </div>
            </div>
          <div class="title">Logging in...</div>
      </div>



      <div class="app-block">
        <div class="col-xs-5">          
          <img src="view/default/assets/images/logo.png">
        </div>        
        <div class="app-form">
          <div class="form-header">
            <div class="app-brand"><span class="highlight">INICIAR</span> SESIÓN</div>
          </div>
          <form action="POST" id="form-login">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1">
                <i class="fa fa-user" aria-hidden="true"></i>
              </span>
              <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" aria-describedby="basic-addon1" required="required">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon2">
                <i class="fa fa-key" aria-hidden="true"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Clave" aria-describedby="basic-addon2" required="required">
            </div>
            <div class="text-center">
                <input type="hidden" value="login" id="opcion" name="opcion">
                <input type="button" id="btnLogin" class="btn btn-success btn-submit" value="Ingresar">
            </div>
        </form>

        <!--
        <div class="form-line">
          <div class="title">OR</div>
        </div>
        <div class="form-footer">
          <button type="button" class="btn btn-default btn-sm btn-social __facebook">
            <div class="info">
              <i class="icon fa fa-facebook-official" aria-hidden="true"></i>
              <span class="title">Login with Facebook</span>
            </div>
          </button>
        </div>

        -->

      </div>
      </div>
    </div>
    <div class="app-footer">
    </div>
  </div>
</div>

  </div>
  <script src="view/default/assets/js/jquery.js"></script>
  <script type="text/javascript" src="view/default/js/login.js"></script>
 <!-- <script type="text/javascript" src="view/default/assets/js/vendor.js"></script>
  <script type="text/javascript" src="view/default/assets/js/app.js"></script> -->
</body>
</html>

<?php } ?>