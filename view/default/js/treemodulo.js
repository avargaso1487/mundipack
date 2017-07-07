function init(){
  $.ajax({
    type:'POST',
    data:{param_opcion: 'listarMenu'},
    url: "../../controller/controlusuario/tree.php",
    success:function(data){
      $('#tree').html(data);
    }
  });
}
init();


/*
  <li class="treeview">
    <a href="#">
      <i class="fa fa-pie-chart"></i>
      <span>Charts</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
      <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
      <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
      <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
    </ul>
  </li>


*/