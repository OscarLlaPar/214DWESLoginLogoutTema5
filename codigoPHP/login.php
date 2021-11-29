<?php
if(isset($_REQUEST['entrar'])){
    header("Location: programa.php");
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <input id="entrar" type="submit" name="entrar" value="Entrar">
    </body>
</html>
