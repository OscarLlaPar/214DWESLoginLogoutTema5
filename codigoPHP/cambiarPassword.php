<?php
    /*
        * Ventana de Registro
        * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
        * Última modificación: 07/12/2021
    */
    //Incluir configuración de la base de datos
    include "../config/confDB.php";
    //Incluir la librería de validación
   include '../core/libreriaValidacion.php';
   //Recuperar la sesión iniciada
   session_start();
   //Si no hay sesión
    if (!isset($_SESSION['usuario214LoginLogout'])) {
        header('Location: login.php'); //Regresar al login
    }
   $entradaOK = true; //Inicialización de la variable que nos indica que todo va bien
   //Inicialización de array de errores
   $aErrores = [
       'password'=>null,
       'passwordNueva'=>null,
       'confirmarPasswordNueva'=>null
   ];
   //Si se ha pulsado el botón de cancelar
   if(!empty($_REQUEST['cancelar'])){
       header('Location: editarPerfil.php'); //Volver atrás
   }
   //Si se ha pulsado el botón de aceptar
   if(!empty($_REQUEST['aceptar'])){
       try{
            //Conexión con la base de datos
            $miDB = new PDO(HOST, USER, PASSWORD);
            //Configuración de errores
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Creación de la consulta
            $consulta=<<<QUERY
                    SELECT T01_Password FROM T01_Usuario
                    WHERE T01_CodUsuario ='{$_SESSION['usuario214LoginLogout']}'
                    QUERY;
            //Preparación de la consulta
            $resultadoConsulta = $miDB->prepare($consulta);
            //Ejecución de la consulta
            $resultadoConsulta->execute();
            //Extracción del resultado a un objeto
            $oRegistro = $resultadoConsulta->fetchObject();
            //Si la contraseña antigua no coincide con la de la base de datos
            if(!$oRegistro || $oRegistro->T01_Password != hash('sha256', $_SESSION['usuario214LoginLogout'].$_REQUEST['password'])){
                $aErrores['password']="Contraseña incorrecta"; //Creación del mensaje de error
                $entradaOK=false; //La entrada no está bien
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
        //Validar la password nueva
       $aErrores['passwordNueva'] = validacionFormularios::validarPassword($_REQUEST['passwordNueva'], 8, 4, 1, 1);
       //Si la contraseña para confirmar no coincide con la nueva
       if($_REQUEST['confirmarPasswordNueva']!=$_REQUEST['passwordNueva']){
           $aErrores['confirmarPasswordNueva']="Las contraseñas no coinciden."; //Creación del mensaje de eror
       }
       foreach($aErrores as $clave=> $error){
            //condición de que hay un error
            if(($error)!=null){
                //limpieza del campo para cuando vuelva a aparecer el formulario
                $_REQUEST[$clave]=""; //Vaciar campos incorrectos
                $entradaOK=false; //La entrada no está bien
            }
        }
        //Si todo ha ido bien
        if($entradaOK){
            //Se crea la nueva password para meter en la base de datos. (nombre de usuario + contraseña encriptados con sha256)
            $nuevaPasswordEncriptada = hash('sha256',$_SESSION['usuario214LoginLogout'].$_REQUEST['passwordNueva']);
            try{

                //Establecimiento de la conexión 
                $miDB = new PDO(HOST, USER, PASSWORD);
                //Configuración de errores
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Preparación de la consulta
                $oConsulta = $miDB->prepare(<<<QUERY
                        UPDATE T01_Usuario
                        SET T01_Password = '{$nuevaPasswordEncriptada}'
                        WHERE T01_CodUsuario = '{$_SESSION['usuario214LoginLogout']}'
                QUERY);
                //Ejecución de la consulta de actualización - Si se ejecuta correctamente
                if($oConsulta->execute()){
                    header('Location: programa.php'); //Redirección a la página de programa
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
        <header>
            <h1>Desarrollo Web en Entorno Servidor</h1>
            <h2>Tema 5</h2>
        </header>
        <form action="cambiarPassword.php" method="get">
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
                            echo (!is_null($aErrores['password']))?"<td>$aErrores[password]</td>":""; //Mostrado del mensaje de error si hay
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
                            echo (!is_null($aErrores['passwordNueva']))?"<td>$aErrores[passwordNueva]</td>":""; //Mostrado del mensaje de error si hay
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
                            echo (!is_null($aErrores['confirmarPasswordNueva']))?"<td>$aErrores[confirmarPasswordNueva]</td>":""; //Mostrado del mensaje de error si hay
                        ?>    
                    </tr>
                </table>
                <input class="boton" type="submit" name="aceptar" value="Aceptar"> 
                <input class="boton" type="submit" name="cancelar" value="Cancelar"> 
            </fieldset>
        </form>
    </body>
</html>
