<?php
ob_start();
?> 

<?	
    session_start();    
    // rol
    // autenticado
    // codigo_usuario
    // login    
	include("conexion.php");
	$link = conexion();	
	
	$contrasena = $_POST['contrasena'];
	$login = $_POST['login'];
	
    $sql_login = "SELECT DISTINCT codigoUsuario, login FROM v_roles v WHERE login = '$login' AND contrasena = md5('$contrasena');";
    $reg_login = mysql_query($sql_login,$link);
    if (mysql_num_rows($reg_login)<>0){
        $fil_login = mysql_fetch_array($reg_login);
        $_SESSION["codigo_usuario"] = $fil_login[0];    
        $_SESSION["login"]          = $fil_login[1];        
    }    
    
    $sql_rol  = "SELECT rol FROM v_roles v WHERE login = '$login' AND contrasena = md5('$contrasena');";
    $reg_rol  = mysql_query($sql_rol,$link);
    $contador = mysql_num_rows($reg_rol);
    
    while($matriz = mysql_fetch_array($reg_rol)){
        $_SESSION["rol"][] = $matriz[0];
    }
    
    print_r($matriz);
    if($contador<>0){        
        //$_SESSION["rol"][]       = $matriz;
        $_SESSION["autenticado"] = 1; 
        header("Location: pedidos.php");
       
    }
    else{
        header("Location: index.php?error=1"); 
    }
?>
<?php
ob_end_flush();
?> 