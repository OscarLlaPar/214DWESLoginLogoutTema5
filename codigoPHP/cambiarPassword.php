<?php
    /*
        * Ventana de Registro
        * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
        * Última modificación: 07/12/2021
    */
    include "../config/confDB.php";
   include '../core/libreriaValidacion.php';
   session_start();
   $entradaOK = true; //Inicialización de la variable que nos indica que todo va bien
   $aErrores = [
       'password'=>null,
       'passwordNueva'=>null,
       'confirmarPasswordNueva'=>null
   ];
   $aRespuestas = [
       'password'=>null,
       'passwordNueva'=>null,
       'confirmarPasswordNueva'=>null
   ];
   if(!empty($_REQUEST['aceptar'])){
       try{
            $miDB = new PDO(HOST, USER, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $consulta=<<<QUERY
                    SELECT T01_Password FROM T01_Usuario
                    WHERE T01_CodUsuario ='{$_SESSION[usuario214LoginLogout]}'
                    QUERY;

            $resultadoConsulta = $miDB->prepare($consulta);
            $resultadoConsulta->execute();
            $oRegistro = $resultadoConsulta->fetchObject();
            
            if(!$oRegistro || $oRegistro->T01_Password != hash('sha256', $_SESSION[usuario214LoginLogout].$_REQUEST['password'])){
                $entradaOK=false;
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
       $aErrores['passwordNueva'] = validacionFormularios::validarPassword($_REQUEST['passwordNueva'], 8, 4, 1, 1);
       if($_REQUEST['confirmarPasswordNueva']!=$_REQUEST['passwordNueva']){
           $aErrores['confirmarPasswordNueva']="Las contraseñas no coinciden.";
       }
       foreach($aErrores as $error){
            //condición de que hay un error
            if(($error)!=null){
                //limpieza del campo para cuando vuelva a aparecer el formulario
                $_REQUEST[key($error)]="";
                $entradaOK=false;
            }
        }
        if($entradaOK){
            $nuevaPasswordEncriptada = hash('sha256',$_SESSION['usuario214LoginLogout'].$_REQUEST['password']);
            try{

                //Establecimiento de la conexión 
                $miDB = new PDO(HOST, USER, PASSWORD);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Preparación de la consulta
                $oConsulta = $miDB->prepare(<<<QUERY
                        UPDATE T01_Usuario
                        SET T01_Password = {$nuevaPasswordEncriptada}
                        WHERE T01_CodUsuario = '{$_SESSION['usuario214LoginLogout']}'
                QUERY);
                //Ejecución de la consulta de actualización
                if($oConsulta->execute()){
                    header('Location: programa.php');
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
   }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cambiar contraseña - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <form action="editarPerfil.php">
            <fieldset>
                <table>
                    <tr>
                        <td>
                            <label for="password">Contraseña actual<span>*</span>: </label>
                        </td>
                        <td>
                            <input type="password" name="password">
                        </td>
                        <?php
                            echo (!is_null($aErrores['password']))?"<td>$aErrores[password]</td>":"";
                        ?>    
                    </tr>
                    <tr>
                        <td>
                            <label for="passwordNueva">Contraseña nueva<span>*</span>: </label>
                        </td>
                        <td>
                            <input type="password" name="passwordNueva">
                        </td>
                        <?php
                            echo (!is_null($aErrores['password']))?"<td>$aErrores[password]</td>":"";
                        ?>    
                    </tr>
                    <tr>
                        <td>
                            <label for="confirmarPasswordNueva">Confirmar contraseña nueva<span>*</span>: </label>
                        </td>
                        <td>
                            <input type="password" name="confirmarPasswordNueva">
                        </td>
                        <?php
                            echo (!is_null($aErrores['confirmarPassword']))?"<td>$aErrores[confirmarPassword]</td>":"";
                        ?>    
                    </tr>
                </table>
                <input class="boton" type="submit" name="aceptar" value="Aceptar"> 
            </fieldset>
        </form>
    </body>
</html>
