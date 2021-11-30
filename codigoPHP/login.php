<?php
include "../config/confDB.php";
$entradaOK=true;
if(isset($_REQUEST['usuario']) && isset($_REQUEST['password'])){
    try{
        $miDB = new PDO(HOST, USER, PASSWORD);
        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $consulta=<<<QUERY
                SELECT T01_Password FROM T01_Usuario
                WHERE T01_CodUsuario ='$_REQUEST[usuario]'
                QUERY;
    
        $resultadoConsulta = $miDB->prepare($consulta);
        $resultadoConsulta->execute();
        $oRegistro = $resultadoConsulta->fetchObject();
        if($oRegistro->T01_Password != hash('sha256', $_REQUEST['usuario'].$_REQUEST['password'])){
            var_dump($oRegistro);
            $entradaOK=false;
        }
        else{
            $consultaUpdate=<<<QUERY
                UPDATE FROM T01_Usuario
                SET T01_FechaHoraUltimaConexion=now(),
                T01_NumConexiones=T01_NumConexiones+1
                WHERE T01_CodUsuario ='$_REQUEST[usuario]'
                QUERY;
            $resultadoConsultaUpdate = $miDB->prepare($consultaUpdate);
            $resultadoConsultaUpdate->execute();   
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
}
else{
    $entradaOK=false;
}
if($entradaOK){
    header("Location: programa.php");
}
else{
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
        <header>
            <h1>Login</h1>
            
            <a href="../index.php"><div class="cuadro" id="arriba">&#60;</div></a>
        </header>
        <form class="login" name="login" action="login.php">
            <fieldset>
                <table>
                    <tr>
                        <td>
                            <label for="usuario">Nombre de usuario: </label>
                        </td>
                        <td>
                            <input id="usuario" type="text" name="usuario" placeholder="Nombre">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Contraseña: </label>
                        </td>
                        <td>
                            <input id="password" type="password" name="password" placeholder="Contraseña">
                        </td>
                    </tr>
                </table>
                <input class="boton" id="entrar" type="submit" name="entrar" value="Entrar">
            </fieldset>
        </form>
        
    </body>
</html>
<?php
}
?>
