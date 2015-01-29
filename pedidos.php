<?
	session_start();
	$codigo_usuario = $_SESSION["codigo_usuario"];
	$login          = $_SESSION["login"];
	$rol            = $_SESSION["rol"];
    
	include("autenticacion.php");

	include("conexion.php");
	$link = conexion();
    include("cabecera.php");
    include("menu.html");
    
    if($_GET){
        $iped = $_GET["iped"];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pedidos Articulos Almacen</title>
<script type="text/javascript" src="js/jquery-1.4.2.js" ></script>
<script type="text/javascript" src="js/jquery.colorize-1.6.0.js" ></script>
<script>
	$(document).ready(function(){
			$("#tbl1").colorize({banColumns:[1,2], oneClick:true} );
			//$("#tbl1").colorize( );

	});
</script>
<script language="javascript">
function solo_numeros(e){
    key=(document.all) ? e.keyCode : e.which;
    
    if (key < 44 || key > 57){
        if (key==8){
            return true
        }
        else
            alert("solo se pueden ingresar numeros");
        return false;
    }
}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
-->
</style>
</head>

<body>

<h1>Registro de Pedidos </h1>
<?
 //   $str_ped = "SELECT origen, nombreArticulo, cantidad, unidad, seccion, solicitante FROM v_detallepedidos WHERE time(now())-time(fechaHoraRegistro)BETWEEN 0 AND 500";
    $str_ped = "SELECT idPedido, origen, nombreArticulo, cantidad, unidad, seccion, solicitante FROM v_detallepedidos WHERE idPedido NOT IN (SELECT idPedido FROM itemSolicitudDinero) AND estado <>4"; 
    $sql_ped = mysql_query($str_ped,$link);
    if (mysql_num_rows($sql_ped)<>0){    
?>
<table width="900" border="0" id="tbl2">
  <tr bgcolor="#FF3300">
    <td width="15"><span class="style1">N&ordm;</span></td>
    <td width="86" align='center'><span class="style1">Origen</span></td>
    <td width="343"><div align="center" class="style1">Descripci&oacute;n</div></td>
    <td width="47" align='center'><span class="style1">Unidad</span></td>
    <td width="58"><div align="center" class="style1">Cant.</div></td>
    <td width="142"><div align="center" class="style1">Secci&oacute;n</div></td>
    <td width="159"><div align="center" class="style1">Solicitante</div></td>
    <td width="20"><div align="center" class="style1"></div></div></td>
  </tr>
  <?
    $cont = 1;
    while($sql_fil = mysql_fetch_array($sql_ped)){
        echo "<form name='form3' method='post' action='pedidos.php'>";            
        echo "<tr style='font-size:11px'>";
            echo "<td>$cont</td>";
            echo "<td>$sql_fil[origen]</td>";
            echo "<td>$sql_fil[nombreArticulo]</td>";
            echo "<td>$sql_fil[unidad]</td>";
            echo "<td align='right'>$sql_fil[cantidad]</td>";
            echo "<td>$sql_fil[seccion]</td>";
            echo "<td>$sql_fil[solicitante]</td>";
            $aux = dechex($sql_fil[idPedido]);         
            echo "<td align = 'center'><a href='pedidos.php?iped=$aux'>Edit.</a></td>";   
        echo "</tr>";
        echo "</form>";
        $cont = $cont + 1;
    }
  }
  ?>
</table>
<p>
  <?
    $flag = 0;
    for($i=0;$i<count($rol);$i++){
        if($rol[$i] == '2'){
            //echo "exito";
            $flag = 1;
        }
    }
    if($flag == 1){
?>
</p>
<form id="form1" name="form1" method="post" action="pedidos.php">
    <table border="0" bgcolor="silver">
        <tr bgcolor="#6699FF">
            <td><span class="style2"><strong>Localizar Articulo</strong></span></td>
          <td><input name="articulo" type="text" id="articulo" onKeyUp="this.value=this.value.toUpperCase();" size="35" maxlength="35"/></td>
      </tr>
  </table>    
</form>
<p>  
<table width="1110" border="0" id="tbl2">
  <tr bgcolor="#6699FF">
    <td width="15"><span class="style1">id</span></td>
    <td width="86" align='center'><span class="style1">Origen</span></td>
    <td width="343"><div align="center" class="style1">Descripci&oacute;n</div></td>
    <td width="47" align='center'><span class="style1">Unidad</span></td>
    <td width="58"><div align="center" class="style1">Cant.</div></td>
    <td width="142"><div align="center" class="style1">Secci&oacute;n</div></td>
    <td width="159"><div align="center" class="style1">Solicitante</div></td>
    <td width="200"><div align="center" class="style1">Observaciones</div></td>
    <td width="67" ><span class="style2"></span></td>
  </tr>
</table>
<table width="1110" border="0" id="tbl1">
  <?
    if($_POST){	
		$articulo = $_POST['articulo'];        
		if(strlen($articulo)>1){					
			$sql_articulos = "SELECT idarticulo, nombreArticulo, unidad FROM articulos WHERE nombreArticulo LIKE '%".$articulo."%'";
			$qry_articulos = mysql_query($sql_articulos,$link);  
			$cont = 1;
			if(mysql_num_rows($qry_articulos) <> 0){
    			while ($res_articulos = mysql_fetch_array($qry_articulos)){
                    ?>
    			 	<form name='form2' method='post' action='msg_pedidos.php'>
                    <input type='hidden' id='flag' name='flag' value='0'/>
                    <input type='hidden' id='id_articulo' name='id_articulo' value='<? echo $res_articulos[0]; ?>'/>
                    <tr style='font-size:11px'>
                        <td width='15' align='right'><? echo $cont; ?></td>
                        <td width='82'>
                            <select name='origen' style='font-size:9px'>
                                <option value='ALMACEN'>ALMACEN</option>
                                <option value='COMPRA'>COMPRA</option>
                            </select>
                        </td>
                        <td width='343'><? echo $res_articulos[1]; ?></td>
                        <td width='47'><? echo $res_articulos[2]; ?></td>
                        <td width='58' align='center'>
                            <input name='cantidad' type='text' id='cantidad' size='6' maxlength='6' style='font-size:10px' onKeypress='solo_numeros(event)'/>
                        </td>
                        <td width='142' align='center'>
                            <input name='seccion' type='text' id='seccion' size='25' maxlength='25' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/>
                        </td>
                        <td width='159' align='center'>
                            <input name='solicitante' type='text' id='solicitante' size='28' maxlength='28' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/>
                        </td>
                        <td width='200' align='center'>
                            <input name='observaciones' type='text' id='observaciones' size='28' maxlength='28' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/>
                        </td>
                        <td width='67' align='center'>
                            <input type='submit' name='Submit2' value='Regist.' style='font-size:10px'>
                        </td>
                    </tr>
                    </form>
                    <?
                    $cont = $cont + 1;
    			} 
			}	
    		else{
                echo "<form name='form2' method='post' action='msg_pedidos.php'>";
                echo "<tr style='font-size:11px'><td width='21'><input type='checkbox' name='flag' id='flag' value='1'/></td>";
                    echo "<td width='77'>";
                        echo "<select name='origen' style='font-size:9px'>";
                        echo "<option value='ALMACEN'>ALMACEN</option>";
                        echo "<option value='COMPRA'>COMPRA</option>";
                        echo "</select>";
                    echo "</td>";                
                    echo "<td width='307' align='center'><input name='articulo' type='text' id='articulo' size='65' maxlength='75' value='$articulo' style='font-size:10px' onKeyUp='this.value=this.value.toUpperCase();'/></td>";
                    echo "<td width='52' align='center'><input name='unidad' type='text' id='unidad' size='3' maxlength='3' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/></td>";
                    echo "<td width='63' align='center'><input name='cantidad' type='text' id='cantidad' size='4' maxlength='4' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/></td>";
                    echo "<td width='142' align='center'><input name='seccion' type='text' id='seccion' size='25' maxlength='25' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/></td>";
                    echo "<td width='159' align='center'><input name='solicitante' type='text' id='solicitante' size='28' maxlength='28' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/></td>";
                    echo "<td width='159' align='center'><input name='observaciones' type='text' id='observaciones' size='28' maxlength='28' style='font-size:10px'onKeyUp='this.value=this.value.toUpperCase();'/></td>";
                    echo "<td width='65' align='center'><input type='submit' name='Submit2' value='Regist.' style='font-size:10px'></td>";
                echo "</tr>";
                echo "</form>";
            }	 
		}        
	}
    
?>
</table>
<?
    } //CON PERMISOS NECESARIOS PARA EJECUTAR
    else{
        echo "<h2>¡¡¡ZONA RESTRINGIDA!!!</h2>";
    }
?>
<p>&nbsp;</p>
</body>
</html>
