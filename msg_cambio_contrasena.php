<?php
    ob_start();
?> 
<?php

/**
 * @author juanito
 * @copyright 2010
 */
 	session_start();
	$login = $_SESSION["login"];

 	include("conexion.php");
	$link = conexion();
    include("menu.html");

    $contrasena_actual    = $_POST['contrasena_actual'];
    $nueva_contrasena     = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    
	$sql = "SELECT * FROM usuarios WHERE contrasena = MD5('$contrasena_actual') AND login = '$login'";
	
    $sql_contrasena_act = mysql_query("SELECT * FROM usuarios WHERE contrasena = MD5('$contrasena_actual') AND login = '$login'",$link);
    
    if(mysql_num_rows($sql_contrasena_act)<>0){
        if($nueva_contrasena == $confirmar_contrasena){
            $sql_udp_contrasena = mysql_query("UPDATE usuarios SET contrasena = MD5('$nueva_contrasena') WHERE login = '$login'",$link);			
            if(mysql_affected_rows($sql_udp_contrasena)<>0){
                header("Location: cerrar_sesion.php");  
            }
        }
        else{
            echo "<h3>Las nuevas contraseñas proporcionadas son diferentes, favor verficar!!!</h3>";
        }
    }
    else{
//		echo $sql;
        echo "<h3>Contraseña Inválida, favor verificar!!!</h3>";
    }

?>
<?php
ob_end_flush();
?>
