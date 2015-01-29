<?
	session_start();
	$autenticado = $_SESSION["autenticado"];
	if(($autenticado <> 1))
	{
		header("Location: index.php?error=1");
	}
?>