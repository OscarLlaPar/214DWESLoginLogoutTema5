<?php
/*
    * Ventana de Programa
    * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
    * Última modificación: 01/12/2021
*/
session_start();
if (!isset($_SESSION['usuario214LoginLogout'])) {
    header('Location: login.php');
}
if (isset($_REQUEST['logout'])) {
    session_destroy();
    header('Location: login.php');
}
include "../config/confDB.php";
$oFecha=new DateTime();
try{
    $miDB = new PDO(HOST, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $consulta=<<<QUERY
            SELECT T01_NumConexiones, T01_DescUsuario FROM T01_Usuario
            WHERE T01_CodUsuario ='{$_SESSION['usuario214LoginLogout']}'
            QUERY;

    $resultadoConsulta = $miDB->prepare($consulta);
    $resultadoConsulta->execute();
    $oRegistro = $resultadoConsulta->fetchObject();
    if($oRegistro){
        $numConexiones=$oRegistro->T01_NumConexiones;
        $usuarioCompleto=$oRegistro->T01_DescUsuario;
    }
}    
//Gestión de errores relacionados con la base de datos
catch(PDOException $miExceptionPDO){
    echo "Error: ".$miExceptionPDO->getMessage();
    echo "<br>";
    echo "Código de error: ".$miExceptionPDO->getCode();
}
finally{
 //Cerrar la conexión
 unset($miDB);
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
        <title>Programa - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <h1>LoginLogout</h1>
            <h2>Tema 5</h2>
            
            <div class="cuadro" ></div>
        </header>
        <main>   
            <div>
                <p>Bienvenido/a <?php echo $usuarioCompleto;?>!</p>
                <p><?php echo ($numConexiones==1)?"Es la primera vez que te conectas!": "Te has conectado {$numConexiones} veces en total";?> </p>
                <p><?php  echo ($numConexiones==1)?"":"Fecha de la última conexión:".$oFecha->setTimestamp($_SESSION['conexionAnterior'])->format("d-m-Y h:i:s")?></p>
            </div>
            <a href="detalle.php"><div class="boton">Detalle</div></a>
            <form name="logout" action="programa.php">
                <input type="submit" class="boton" name="logout" value="Cerrar sesión" type="button"/>
            </form>
           
        </main>
        <footer>
            <p>
                Óscar Llamas Parra &nbsp;
                <a href="https://github.com/OscarLlaPar/" target="__blank"><img src="../webroot/img/github.png" alt="Github"></img></a>
            </p>
            <p>
                DAW 2
            </p>
            <p>
                IES Los Sauces, Benavente 2021-2022
            </p>
            <div class="cuadro" id="abajo"></div>
        </footer>
    </body>
</html>
