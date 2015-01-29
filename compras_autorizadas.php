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
        $fecha = $_POST['fecha'];
        $filtro = $_POST['filtro'];
    }
?>
<html>
<head>
<title>ORDENES DE COMPRA</title>

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
		$('#fecha').datepick();
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
<h1>Compras Autorizadas</h1>
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
<form action="compras_autorizadas.php" name="form1" id="form1" method="post">
  <table width="439" border="0" id="tabla3">
    <tr>
      <td width="97">Fecha: </td>
      <td width="359"><input name="fecha" type="text" id="fecha" size="10" maxlength="10" style="text-align: right;"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>      
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<table width='806' border='0' id='tabla5'>
  <tr bgcolor='#6699FF'>
    <td width='29'><span class="style2">N&ordm;</span></td>
    <td width='154' bgcolor='#59ACFF'><span class="style2">Fecha Autorizacion</span></td>
    <td width='297' bgcolor='#59ACFF'><div align='center' class="style2">Descripci&oacute;n</div></td>
    <td width='36'><div align='center' class="style2">Cant.</div></td>
    <td width='36'><div align='center' class="style2">Unid.</div></td>
    <td width='120'><div align='center' class="style2">Secci&oacute;n</div></td>
    <td width='140'><div align='center' class="style2">Solicitante</div></td>    
  </tr>
</table>
<form action="msg_orden_compra.php" method="post" name="form3">
<table width='806' border='0' id='tabla1'>
  <?    
    $sql = "SELECT fechaHoraOrdenCompra, nombreArticulo, cantidad, unidad, seccion, solicitante FROM v_detallepedidos WHERE estado = 2";
    if($_POST)
    {    
        $fecha1 = $fecha.' 00:00:01';
        $fecha2 = $fecha.' 23:59:59';
        if($fecha<>''){
            $sql = "SELECT fechaHoraOrdenCompra, nombreArticulo, cantidad, unidad, seccion, solicitante FROM v_detallepedidos WHERE estado = 2 AND fechaHoraOrdenCompra BETWEEN '$fecha1' AND '$fecha2'";    
        }
        

        //echo $sql;
    }
                
        $sql_pedidos = mysql_query($sql,$link);
        $cont = 0;
        while($res_pedidos = mysql_fetch_array($sql_pedidos)){
            $cont = $cont + 1;
            echo "<tr style='font-size:11px'>";
                echo "<td width='25'>$cont</td>";
                echo "<td width='135'>$res_pedidos[fechaHoraOrdenCompra]</td>";
                echo "<td width='261'>$res_pedidos[nombreArticulo]</td>";
                echo "<td width='32' align='right'>$res_pedidos[cantidad]</td>";
                echo "<td width='32' align='right'>$res_pedidos[unidad]</td>";
                echo "<td width='108' align='left'>$res_pedidos[seccion]</td>";
                echo "<td width='122' align='left'>$res_pedidos[solicitante]</td>";                
            echo "</tr>";
        }    
    
  ?>
</table>

<table width="805">
  <tr bgcolor='#59ACFF'>
    <td width="103"><div align="center"></td>
    
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