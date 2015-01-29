<?
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
        $filtro = $_POST['filtro'];
    }

?>
<html>
<head>
<title>Lista Pedidos</title>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery.datepick.js"></script>

<script type="text/javascript" src="js/jquery.colorize-1.6.0.js" ></script>

<style type="text/css">
@import "js/jquery.datepick.css";
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
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
<h1>Lista Pedidos</h1>
<form action="lista_pedidos.php" name="form1" id="form1" method="post">
  <table width="439" border="0" id="tabla3">
    <tr>
      <td width="97">Fecha Inicio: </td>
      <td width="359"><input name="fecha1" type="text" id="fecha1" size="10" maxlength="10" style="text-align: right;"></td>
    </tr>
    <tr>
      <td>Fecha Final:</td>
      <td><input name="fecha2" type="text" id="fecha2" size="10" maxlength="10" style="text-align: right;"></td>
    </tr>
    <tr>
      <td>Filtro Pedido</td>
      <td><input name="filtro" type="text" id="filtro" size="30" maxlength="30" style="text-align: right;" onKeyUp="this.value=this.value.toUpperCase();"></td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="Buscar" /></td>      
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<table width="1030" border="0">
	<tr bgcolor="#6699FF">
	  <td width="15"><span class="style1">N&ordm;</span></td>
      <td width="40"><span class="style1">Origen</span></td>      
	  <td width="144"><div align="center" class="style1">Nombre Art&iacute;culo </div></td>
	  <td width="20"><div align="center" class="style1">Cant</div></td>
      <td width="27"><div align="center" class="style1">Uni.</div></td>
	  <td width="88" bgcolor="#6699FF"><div align="center" class="style1">Secci&oacute;n</div></td>
	  <td width="122"><div align="center" class="style1">Solicitante</div></td>
	  <td width="90"><div align="center" class="style1">F/H Pedido  </div></td>
	  <td width="90"><div align="center" class="style1">F/H Almac&eacute;n </div></td>
	  <td width="90"><div align="center" class="style1">F/H Orden </div></td>
	  <td width="90"><div align="center" class="style1">F/H Compra </div></td>                
  </tr>
</table>

<?php      

    $sql_sel  = "SELECT origen, estado, fecha, nombreArticulo, cantidad, unidad, seccion, solicitante, fechaHoraRegistro, fechaHoraAlmacen, fechaHoraOrdenCompra, fechaHoraCotejado";  
    
    if($fecha1==''){
        if(strlen($filtro)>1){
            $sql_from = "FROM v_detallepedidos v";
            $sql_wher = "WHERE CONCAT(nombreArticulo,seccion,solicitante) LIKE '%$filtro%'";
        }        
    }
    else{
        $sql_from = "FROM v_detallepedidos v";
        $sql_wher = "WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND CONCAT(nombreArticulo,seccion,solicitante) LIKE '%$filtro%'";        
    }
    
    
    $sql_cadena = $sql_sel.' '.$sql_from.' '.$sql_wher.' ORDER BY fecha DESC';
    
    //echo $sql_cadena;
     
    $sql_ped = mysql_query($sql_cadena,$link);
    $cont = 1;
    echo "<table width='1030' border='0' id='tabla1'>";
    while($sql_fil = mysql_fetch_array($sql_ped)){
        echo "<tr style='font-size:11px'>";
            echo "<td width='15' align='right'>$cont</td>";
            echo "<td width='40'>$sql_fil[0]</td>";
            echo "<td width='140'>$sql_fil[3]</td>";
            echo "<td width='30' align='right'>$sql_fil[4]</td>";
            echo "<td width='25'>$sql_fil[5]</td>";
            echo "<td width='88'>$sql_fil[6]</td>";
            echo "<td width='120'>$sql_fil[7]</td>";
            echo "<td width='90' align='right'>$sql_fil[8]</td>";
            if(($sql_fil[0]<>4)and($sql_fil[0]<>5)){
                if(strlen($sql_fil[7])<>0){echo "<td width='90' align='right'>$sql_fil[9]</td>";}
                else{echo "<td width='84' align='center'> --- </td>";}
                
                if(strlen($sql_fil[8])<>0){echo "<td width='90' align='right'>$sql_fil[10]</td>";}
                else{echo "<td width='84' align='center'> --- </td>";}
                
                if(strlen($sql_fil[9])<>0){echo "<td width='90' align='right'>$sql_fil[11]</td>";}
                else{echo "<td width='84' align='center'> --- </td>";}
            }
            else{
                if($sql_fil[0]==4){
                    echo "<td width='90' align='center'>--ANULADO--</td>";
                    echo "<td width='90' align='center'>--ANULADO--</td>";
                    echo "<td width='90' align='center'>--ANULADO--</td>";
                }
                else{
                    echo "<td width='90' align='center'>--ALMACEN--</td>";
                    echo "<td width='90' align='center'>--ALMACEN--</td>";
                    echo "<td width='90' align='center'>--ALMACEN--</td>";
                }
            }
            
        echo "</tr>";        
        $cont = $cont + 1;
    }
?>
</table>
</body>
</html>

