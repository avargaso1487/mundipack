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
  <title>MUNDIPACK | Administrador</title>

  <meta http-equiv="Content-Type" content="IE=Edge; chrome=1"> 
  <meta charset="UTF-8"">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="../default/assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../default/css/estrellas.css">
  <link rel="stylesheet" type="text/css" href="../default/assets/css/flat-admin.css">
  <link rel="stylesheet" type="text/css" href="../default/css/sweetalert.css">    
  
  
  
  <link rel="stylesheet" href="../default/assets_acemaster/font-awesome/4.2.0/css/font-awesome.min.css" />

  <!-- page specific plugin styles -->
  
  
  
  <link rel="stylesheet" href="../default/assets_acemaster/fonts/fonts.googleapis.com.css" />
  
  <script src="../default/assets_acemaster/js/ace-extra.min.js"></script>

  <link rel="stylesheet" href="../default/assets_acemaster/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

  

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

<input type="hidden" dissabled="true" value="Administrador" id="Menu">

<div class="row">
 <div class="col-xs-12">
      <div class="card">
        <div class="card-header">
          <p class="UserNameTitle" id="netpartner_nombrecomercial">Perfil de DOÑA PETA</p>
        </div>
        <div class="card-body padding">                    
            <div id="user-profile-1" class="user-profile row">
              <div class="col-xs-12 col-sm-3 center">
                <div>
                  <span class="profile-img">
                    <img class="img-responsive" alt="Net Partner" src="../default/assets/images/profile.png" />
                  </span>
                  <div class="space-4"></div>                      
                </div>                    
              </div>
              <div class="col-xs-12 col-sm-5">                      
                <div class="profile-user-info profile-user-info-striped">
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Razón Social </div>
                    <div class="profile-info-value">
                      <!--Valor se reemplaza esde modelo-->
                      <span id="netpartner_RazonSocial">Doña Peta S.A.C.</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> RUC </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">12345678901</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Nombre Comercial </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">Doña Peta</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Rubro </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">Restaurante</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Dirección </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">3 hours ago</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> T. Contacto </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">044782937</span>
                    </div>                  
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> T. Atención </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">044782937</span>
                    </div>                  
                  </div>
                </div>
              </div>                  

              <div class="col-xs-12 col-sm-4">                      
                <div class="profile-user-info profile-user-info-striped">
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Razón Social </div>
                    <div class="profile-info-value">
                      <!--Valor se reemplaza esde modelo-->
                      <span id="netpartner_RazonSocial">Doña Peta S.A.C.</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> RUC </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">12345678901</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Nombre Comercial </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">Doña Peta</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Rubro </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">Restaurante</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> Dirección </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">3 hours ago</span>
                    </div>
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> T. Contacto </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">044782937</span>
                    </div>                  
                  </div>

                  <div class="profile-info-row">
                    <div class="profile-info-name"> T. Atención </div>

                    <div class="profile-info-value">
                      <span  id="netpartner_RazonSocial">044782937</span>
                    </div>                  
                  </div>
                </div>
              </div>                  
        </div>
      </div>
    </div>
    </div>




<!-- MODAL -->

    <div class="modal fade" id="modalSocio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Nuevo NET PARTNER</h4>
            
          </div>      

          <div class="modal-body">

          <div id="mensaje" class="col-md-12"></div>
            <form class="form form-horizontal" method="post" id="frm_nuevoSocio" style="font-size: 12px;">
                                    
                  <!-- Razón Social -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Razón Social</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" placeholder="Razón Social" name="socioRazonSocial" id="socioRazonSocial" >
                    </div>
                  </div>

                  <!-- RUC -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">RUC</label>
                    <div class="col-md-9">
                      <input type="text" maxlength="11" class="form-control" placeholder="RUC" onkeypress="return solonumeros(event)" name="socioRUC" id="socioRUC" >
                    </div>
                  </div>

                  <!-- Nombre Comercial -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Nombre Comercial</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" placeholder="Nombre Comercial" name="socioNombreComercial" id="socioNombreComercial" >
                    </div>
                  </div>                

                  <!-- Rubro Empresarial -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Rubro</label>
                    <div class="col-md-9">
                      <select class="form-control" id="socioRubro" name="socioRubro">
                        <option value="" disabled selected style="display: none;">Seleccionar Rubro</option>
                        <option value="3">Cafetería</option>
                        <option value="4">Hotel</option>
                        <option value="1">Restaurante</option>
                        <option value="2">SPA</option>
                      </select>                      
                    </div>
                  </div>

                  <!-- Dirección -->
                  <div class="form-group">
                    <div class="col-md-3">
                      <label class="control-label">Dirección</label>
                      <p class="control-label-help">(Calle/Urbanización/Oficina/Distrito)</p>
                    </div>
                    <div class="col-md-9">
                      <textarea class="form-control"  name="socioDireccion" id="socioDireccion" ></textarea>
                    </div>
                  </div>

                  <!-- Telefono -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Teléfono</label>
                    <div class="col-md-9">
                      <div class="col-md-6">
                        <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Contacto"  name="socioTelefonoContacto" id="socioTelefonoContacto">
                      </div>
                      <div class="col-md-6">
                        <input type="tel" class="form-control" onkeypress="return solonumeros(event)" placeholder="Atención"  name="socioTelefonoAtencion" id="socioTelefonoAtencion">
                      </div>                      
                    </div>
                  </div>                

                  <!-- Email -->
                  <div class="form-group">
                    <label class="col-md-3 control-label">Email</label>
                    <div class="col-md-9">
                      <input type="email" class="form-control" placeholder="email@example.com" name="socioEmail" id="socioEmail" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Nro. Cuenta</label>
                    <div class="col-md-9">
                      <input class="form-control" placeholder="Número de Cuenta" name="socioNroCuenta" id="socioNroCuenta" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">Contacto Responsable</label>
                    <div class="col-md-9">
                      <input class="form-control" placeholder="Nombre del Contacto" name="socioContactoResponsable" id="socioContactoResponsable" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label">% de Retorno</label>
                    <div class="col-md-9">
                      <input class="form-control" placeholder="% de Retorno" name="socioPrctjRetorno" id="socioPrctjRetorno" >
                    </div>
                  </div>                

                  <div class="form-group">
                    <label class="col-md-3 control-label">Categoría</label>
                    <div class="col-md-2">
                      <p class="clasificacion">
                            <input type="radio" name="socioCategoria" id="socioCategoria1" value="5"><!--
                        --><label for="socioCategoria1">★</label><!--
                        --><input id="socioCategoria2" type="radio" name="socioCategoria"  value="4"><!--
                        --><label for="socioCategoria2">★</label><!--
                        --><input id="socioCategoria3" type="radio" name="socioCategoria" value="3"><!--
                        --><label for="socioCategoria3">★</label><!--
                        --><input id="socioCategoria4" type="radio" name="socioCategoria" value="2"><!--
                        --><label for="socioCategoria4">★</label><!--
                        --><input id="socioCategoria5" type="radio" name="socioCategoria" value="1"><!--
                        --><label for="socioCategoria5">★</label>
                      </p>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                    <input style="display:none;" type="button" id="guardarSocio" data-dismiss="modal" class="btn btn-sm btn-primary" onclick="guardar();" value="Guardar"/>
                    <input style="display:none;" type="button" id="editarSocio" data-dismiss="modal" class="btn btn-sm btn-primary" onclick="editar();" value="Modificar"/>
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
  <script src="../default/js/listar_socios.js"></script>
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

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {
      
        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
          $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>'+
                                      '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';    
        
        //editables 
        
        //text editable
          $('#username')
        .editable({
          type: 'text',
          name: 'username'
          });
      
      
        
        //select2 editable
        var countries = [];
          $.each({ "CA": "Canada", "IN": "India", "NL": "Netherlands", "TR": "Turkey", "US": "United States"}, function(k, v) {
              countries.push({id: k, text: v});
          });
      
        var cities = [];
        cities["CA"] = [];
        $.each(["Toronto", "Ottawa", "Calgary", "Vancouver"] , function(k, v){
          cities["CA"].push({id: v, text: v});
        });
        cities["IN"] = [];
        $.each(["Delhi", "Mumbai", "Bangalore"] , function(k, v){
          cities["IN"].push({id: v, text: v});
        });
        cities["NL"] = [];
        $.each(["Amsterdam", "Rotterdam", "The Hague"] , function(k, v){
          cities["NL"].push({id: v, text: v});
        });
        cities["TR"] = [];
        $.each(["Ankara", "Istanbul", "Izmir"] , function(k, v){
          cities["TR"].push({id: v, text: v});
        });
        cities["US"] = [];
        $.each(["New York", "Miami", "Los Angeles", "Chicago", "Wysconsin"] , function(k, v){
          cities["US"].push({id: v, text: v});
        });
        
        var currentValue = "NL";
          $('#country').editable({
          type: 'select2',
          value : 'NL',
          //onblur:'ignore',
              source: countries,
          select2: {
            'width': 140
          },    
          success: function(response, newValue) {
            if(currentValue == newValue) return;
            currentValue = newValue;
            
            var new_source = (!newValue || newValue == "") ? [] : cities[newValue];
            
            //the destroy method is causing errors in x-editable v1.4.6+
            //it worked fine in v1.4.5
            /**     
            $('#city').editable('destroy').editable({
              type: 'select2',
              source: new_source
            }).editable('setValue', null);
            */
            
            //so we remove it altogether and create a new element
            var city = $('#city').removeAttr('id').get(0);
            $(city).clone().attr('id', 'city').text('Select City').editable({
              type: 'select2',
              value : null,
              //onblur:'ignore',
              source: new_source,
              select2: {
                'width': 140
              }
            }).insertAfter(city);//insert it after previous instance
            $(city).remove();//remove previous instance
            
          }
          });
      
        $('#city').editable({
          type: 'select2',
          value : 'Amsterdam',
          //onblur:'ignore',
              source: cities[currentValue],
          select2: {
            'width': 140
          }
          });
      
      
        
        //custom date editable
        $('#signup').editable({
          type: 'adate',
          date: {
            //datepicker plugin options
                format: 'yyyy/mm/dd',
            viewformat: 'yyyy/mm/dd',
             weekStart: 1
             
            //,nativeUI: true//if true and browser support input[type=date], native browser control will be used
            //,format: 'yyyy-mm-dd',
            //viewformat: 'yyyy-mm-dd'
          }
        })
      
          $('#age').editable({
              type: 'spinner',
          name : 'age',
          spinner : {
            min : 16,
            max : 99,
            step: 1,
            on_sides: true
            //,nativeUI: true//if true and browser support input[type=number], native browser control will be used
          }
        });
        
      
          $('#login').editable({
              type: 'slider',
          name : 'login',
          
          slider : {
             min : 1,
              max: 50,
            width: 100
            //,nativeUI: true//if true and browser support input[type=range], native browser control will be used
          },
          success: function(response, newValue) {
            if(parseInt(newValue) == 1)
              $(this).html(newValue + " hour ago");
            else $(this).html(newValue + " hours ago");
          }
        });
      
        $('#about').editable({
          mode: 'inline',
              type: 'wysiwyg',
          name : 'about',
      
          wysiwyg : {
            //css : {'max-width':'300px'}
          },
          success: function(response, newValue) {
          }
        });
        
        
        
        // *** editable avatar *** //
        try {//ie8 throws some harmless exceptions, so let's catch'em
      
          //first let's add a fake appendChild method for Image element for browsers that have a problem with this
          //because editable plugin calls appendChild, and it causes errors on IE at unpredicted points
          try {
            document.createElement('IMG').appendChild(document.createElement('B'));
          } catch(e) {
            Image.prototype.appendChild = function(el){}
          }
      
          var last_gritter
          $('#avatar').editable({
            type: 'image',
            name: 'avatar',
            value: null,
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Change Avatar',
              droppable: true,
              maxSize: 110000,//~100Kb
      
              //and a few extra ones here
              name: 'avatar',//put the field name here as well, will be used inside the custom plugin
              on_error : function(error_type) {//on_error function will be called when the selected file has a problem
                if(last_gritter) $.gritter.remove(last_gritter);
                if(error_type == 1) {//file format error
                  last_gritter = $.gritter.add({
                    title: 'File is not an image!',
                    text: 'Please choose a jpg|gif|png image!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(error_type == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'File too big!',
                    text: 'Image size should not exceed 100Kb!',
                    class_name: 'gritter-error gritter-center'
                  });
                }
                else {//other error
                }
              },
              on_success : function() {
                $.gritter.removeAll();
              }
            },
              url: function(params) {
              // ***UPDATE AVATAR HERE*** //
              //for a working upload example you can replace the contents of this function with 
              //examples/profile-avatar-update.js
      
              var deferred = new $.Deferred
      
              var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
              if(!value || value.length == 0) {
                deferred.resolve();
                return deferred.promise();
              }
      
      
              //dummy upload
              setTimeout(function(){
                if("FileReader" in window) {
                  //for browsers that have a thumbnail of selected image
                  var thumb = $('#avatar').next().find('img').data('thumb');
                  if(thumb) $('#avatar').get(0).src = thumb;
                }
                
                deferred.resolve({'status':'OK'});
      
                if(last_gritter) $.gritter.remove(last_gritter);
                last_gritter = $.gritter.add({
                  title: 'Avatar Updated!',
                  text: 'Uploading to server can be easily implemented. A working example is included with the template.',
                  class_name: 'gritter-info gritter-center'
                });
                
               } , parseInt(Math.random() * 800 + 800))
      
              return deferred.promise();
              
              // ***END OF UPDATE AVATAR HERE*** //
            },
            
            success: function(response, newValue) {
            }
          })
        }catch(e) {}
        
        /**
        //let's display edit mode by default?
        var blank_image = true;//somehow you determine if image is initially blank or not, or you just want to display file input at first
        if(blank_image) {
          $('#avatar').editable('show').on('hidden', function(e, reason) {
            if(reason == 'onblur') {
              $('#avatar').editable('show');
              return;
            }
            $('#avatar').off('hidden');
          })
        }
        */
      
        //another option is using modals
        $('#avatar2').on('click', function(){
          var modal = 
          '<div class="modal fade">\
            <div class="modal-dialog">\
             <div class="modal-content">\
            <div class="modal-header">\
              <button type="button" class="close" data-dismiss="modal">&times;</button>\
              <h4 class="blue">Change Avatar</h4>\
            </div>\
            \
            <form class="no-margin">\
             <div class="modal-body">\
              <div class="space-4"></div>\
              <div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
             </div>\
            \
             <div class="modal-footer center">\
              <button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Submit</button>\
              <button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
             </div>\
            </form>\
            </div>\
           </div>\
          </div>';
          
          
          var modal = $(modal);
          modal.modal("show").on("hidden", function(){
            modal.remove();
          });
      
          var working = false;
      
          var form = modal.find('form:eq(0)');
          var file = form.find('input[type=file]').eq(0);
          file.ace_file_input({
            style:'well',
            btn_choose:'Click to choose new avatar',
            btn_change:null,
            no_icon:'ace-icon fa fa-picture-o',
            thumbnail:'small',
            before_remove: function() {
              //don't remove/reset files while being uploaded
              return !working;
            },
            allowExt: ['jpg', 'jpeg', 'png', 'gif'],
            allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
          });
      
          form.on('submit', function(){
            if(!file.data('ace_input_files')) return false;
            
            file.ace_file_input('disable');
            form.find('button').attr('disabled', 'disabled');
            form.find('.modal-body').append("<div class='center'><i class='ace-icon fa fa-spinner fa-spin bigger-150 orange'></i></div>");
            
            var deferred = new $.Deferred;
            working = true;
            deferred.done(function() {
              form.find('button').removeAttr('disabled');
              form.find('input[type=file]').ace_file_input('enable');
              form.find('.modal-body > :last-child').remove();
              
              modal.modal("hide");
      
              var thumb = file.next().find('img').data('thumb');
              if(thumb) $('#avatar2').get(0).src = thumb;
      
              working = false;
            });
            
            
            setTimeout(function(){
              deferred.resolve();
            } , parseInt(Math.random() * 800 + 800));
      
            return false;
          });
              
        });
      
        
      
        //////////////////////////////
        $('#profile-feed-1').ace_scroll({
          height: '250px',
          mouseWheelLock: true,
          alwaysVisible : true
        });
      
        $('a[ data-original-title]').tooltip();
      
        $('.easy-pie-chart.percentage').each(function(){
        var barColor = $(this).data('color') || '#555';
        var trackColor = '#E2E2E2';
        var size = parseInt($(this).data('size')) || 72;
        $(this).easyPieChart({
          barColor: barColor,
          trackColor: trackColor,
          scaleColor: false,
          lineCap: 'butt',
          lineWidth: parseInt(size/10),
          animate:false,
          size: size
        }).css('color', barColor);
        });
        
        ///////////////////////////////////////////
      
        //right & left position
        //show the user info on right or left depending on its position
        $('#user-profile-2 .memberdiv').on('mouseenter touchstart', function(){
          var $this = $(this);
          var $parent = $this.closest('.tab-pane');
      
          var off1 = $parent.offset();
          var w1 = $parent.width();
      
          var off2 = $this.offset();
          var w2 = $this.width();
      
          var place = 'left';
          if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) place = 'right';
          
          $this.find('.popover').removeClass('right left').addClass(place);
        }).on('click', function(e) {
          e.preventDefault();
        });
      
      
        ///////////////////////////////////////////
        $('#user-profile-3')
        .find('input[type=file]').ace_file_input({
          style:'well',
          btn_choose:'Change avatar',
          btn_change:null,
          no_icon:'ace-icon fa fa-picture-o',
          thumbnail:'large',
          droppable:true,
          
          allowExt: ['jpg', 'jpeg', 'png', 'gif'],
          allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
        })
        .end().find('button[type=reset]').on(ace.click_event, function(){
          $('#user-profile-3 input[type=file]').ace_file_input('reset_input');
        })
        .end().find('.date-picker').datepicker().next().on(ace.click_event, function(){
          $(this).prev().focus();
        })
        $('.input-mask-phone').mask('(999) 999-9999');
      
        $('#user-profile-3').find('input[type=file]').ace_file_input('show_file_list', [{type: 'image', name: $('#avatar').attr('src')}]);
      
      
        ////////////////////
        //change profile
        $('[data-toggle="buttons"] .btn').on('click', function(e){
          var target = $(this).find('input[type=radio]');
          var which = parseInt(target.val());
          $('.user-profile').parent().addClass('hide');
          $('#user-profile-'+which).parent().removeClass('hide');
        });
        
        
        
        /////////////////////////////////////
        $(document).one('ajaxloadstart.page', function(e) {
          //in ajax mode, remove remaining elements before leaving page
          try {
            $('.editable').editable('destroy');
          } catch(e) {}
          $('[class*=select2]').remove();
        });
      });
    </script>
</body>
</html>

<?php } ?>