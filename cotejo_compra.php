<?php

/**
 * @author juanito
 * @copyright 2010
 */
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login          = $_SESSION["login"];
	$rol            = $_SESSION["rol"];
	
	include("autenticacion.php");

	include("conexion.php");
	$link = conexion();
    include("cabecera.php");
    include("menu.html");

    if($_POST){
        $fecha1 = $_POST['fecha1'];
        $fecha2 = $_POST['fecha2'];
        $estado = $_POST['pendiente'];
        $filtro = $_POST['filtro'];
    }
    else{
        $estado = 1;
    }
?>
<html>
<head>
<title>COTEJO COMPRA</title>

<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery.datepick.js"></script>

<script type="text/javascript" src="js/jquery.colorize-1.6.0.js" ></script>

<style type="text/css">
@import "js/jquery.datepick.css";.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {color: #FFFFFF}
</style> 
<script type="text/javascript">
    $(function() {	
		$('#fecha1').datepick();
	});
    $(function() {	
	   $('#fecha2').datepick();
    });
</script>

<script>
	$(document).ready(function(){
			$("#tabla1").colorize({banColumns:[1,2,3], oneClick:true} );
			//$("#tbl1").colorize( );

	});
</script>

</head>
<body>
<h1>Cotejo Compra</h1>
<?
    $flag = 0;
    for($i=0;$i<count($rol);$i++){
        if($rol[$i] == '5'){
            //echo "exito";
            $flag = 1;
        }
    }
    if($flag == 1){
?>

<form action="cotejo_compra.php" name="form1" id="form1" method="post">
  <table width="475" border="0" id="tabla3">
    <tr>
      <td width="91">Fecha Inicio: </td>
      <td width="80">Fecha Final:</td>
      <td width="195">Filtro Pedido</td>
      <td width="91">Pendientes</td>
    </tr>
    <tr>
      <td><input name="fecha1" type="text" id="fecha1" size="10" maxlength="10" style="text-align: right;"></td>
      <td><input name="fecha2" type="text" id="fecha2" size="10" maxlength="10" style="text-align: right;"></td>
      <td><input name="filtro" type="text" id="filtro" size="30" maxlength="30" style="text-align: right;" onKeyUp="this.value=this.value.toUpperCase();"></td>
      <td><input type="checkbox" value="1" id="pendiente" name="pendiente" checked="true"/></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<table width='951' border='0' id='tabla5'>
  <tr bgcolor='#6699FF'>
    <td width='28'><span class="style2">N&ordm;</span></td>
    <td width='68' bgcolor='#59ACFF'><span class="style2">Cod.Solic.</span></td>
    <td width='68' bgcolor='#59ACFF'><span class="style2">Fecha</span></td>
    <td width='296' bgcolor='#59ACFF'><div align='center' class="style2">Descripci&oacute;n</div></td>
    <td width='36'><div align='center' class="style2">Cant.</div></td>
    <td width='31'><span class="style2">Unid</span></td>
    <td width='151'><div align='center' class="style2">Secci&oacute;n</div></td>
    <td width='198'><div align='center' class="style2">Solicitante</div></td>
    <td width='41' ><span class="style3"></span></td>
  </tr>
</table>
<form action="msg_cotejo_compra.php" method="post" name="form3">
<table width='951' border='0' id='tabla1'>
  <?
  $str_sel = "SELECT codigoSolicitud, v.idPedido, v.fecha as FechaPedido, s.fecha as fechaSolicitud, v.nombreArticulo, v.cantidad, v.unidad, v.seccion, v.solicitante";
  $str_fro = "FROM v_detallepedidos v JOIN itemSolicitudDinero i ON v.idPedido = i.idPedido JOIN solicitudDinero s ON i.idSolicitud = s.idSolicitud";
  $str_whe = "WHERE v.estado = 2";
  
  $str_sql = $str_sel.' '.$str_fro.' '.$str_whe;    
  
    if($_POST)
    {    
		if($estado == 1){
		  if($fecha1==''){
            if(strlen($filtro)>1){$str_sql = $str_sel.' '.$str_fro." WHERE v.estado = 2 AND CONCAT(nombreArticulo,seccion,solicitante) LIKE '%$filtro%'";}		    
		  }
          else{
            $str_sql = $str_sel.' '.$str_fro." WHERE v.estado = 2 AND fecha BETWEEN '$fecha1' AND '$fecha2' AND CONCAT(nombreArticulo,seccion,solicitante) LIKE '%$filtro%'";
          }
        }
        else {
		  if($fecha1==''){
            if(strlen($filtro)>1){$str_sql = $str_sel.' '.$str_fro." WHERE v.estado = 3 AND CONCAT(nombreArticulo,seccion,solicitante) LIKE '%$filtro%'";}		    
		  }
          else{
            $str_sql = $str_sel.' '.$str_fro." WHERE .vestado = 3 AND fecha BETWEEN '$fecha1' AND '$fecha2' AND CONCAT(nombreArticulo,seccion,solicitante) LIKE '%$filtro%'";
          }
        }
        //echo $sql;
        unset($fecha1);
        unset($fecha2);
        unset($filtro);
    }
        //echo $str_sql;
        $sql_pedidos = mysql_query($str_sql,$link);
        $cont = 0;
        while($res_pedidos = mysql_fetch_array($sql_pedidos)){
            $cont = $cont + 1;
            echo "<tr style='font-size:11px'>";
                echo "<td width='28'>$cont</td>";
                echo "<td width='68'>$res_pedidos[codigoSolicitud]</td>";
                echo "<td width='68'>$res_pedidos[FechaPedido]</td>";
                echo "<td width='296'>$res_pedidos[nombreArticulo]</td>";
                echo "<td width='36' align='right'>$res_pedidos[cantidad]</td>";
                echo "<td width='31' align='left'>$res_pedidos[unidad]</td>";
                echo "<td width='151' align='left'>$res_pedidos[seccion]</td>";
                echo "<td width='198' align='left'>$res_pedidos[solicitante]</td>";
                if ($estado == 1){
                    echo "<td width='41' align= 'center'><input type='checkbox' value='$res_pedidos[0]' name='id_pedido[]'/></td>";
                }
                else{echo "<td width='41' align='left'>$res_pedidos[9]</td>";}
            echo "</tr>";
        }
    
    
  ?>
</table>

<table width="951">
  <tr bgcolor='#59ACFF'>
    <td width="90"><div align="center">
    <? if ($estado == 1){?>
      <input name="confirmar" type="submit" id="confirmar" value="Confirmar">
    <? }?>  
    </div></td>
    
    <td width="578" bgcolor='#59ACFF'>&nbsp;</td>
  </tr>
</table>
<?
    } //CON PERMISOS NECESARIOS PARA EJECUTAR
    else{
        echo "<h2>¡¡¡ZONA RESTRINGIDA!!!</h2>";
    }
?>

</form>
</body>

</html>