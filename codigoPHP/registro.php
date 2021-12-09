<?php
    /*
        * Ventana de Registro
        * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
        * Última modificación: 07/12/2021
    */
    include "../config/confDB.php";
   include '../core/libreriaValidacion.php';
   $entradaOK = true; //Inicialización de la variable que nos indica que todo va bien
   $aErrores = [
       'nombreUsuario'=>null,
       'descUsuario'=>null,
       'password'=>null,
       'confirmarPassword'=>null
   ];
   $aRespuestas = [
       'nombreUsuario'=>null,
       'descUsuario'=>null,
       'password'=>null
   ];
   if(!empty($_REQUEST['registrarse'])){
       $aErrores['nombreUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['nombreUsuario'], 8, 3, 1);
       //Validación de clave primaria (solo en caso de que la función la confirme como válida)
        if($aErrores['nombreUsuario'] == null){
            try{
                //Establecimiento de la conexión
                $miDB = new PDO(HOST, USER, PASSWORD);

                $miDB -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Elaboración y preparación de la consulta
                $consulta=<<<QUERY
                    SELECT * FROM T01_Usuario WHERE T01_CodUsuario = '{$_REQUEST['nombreUsuario']}'
                    QUERY;
                $resultadoConsulta = $miDB->prepare($consulta);
                //Ejecución de la consulta
                $resultadoConsulta->execute();
                //Carga de una fila del resultado en una variable
                $registroConsulta = $resultadoConsulta->fetchObject();
                if($registroConsulta){ 
                    $aErrores['nombreUsuario']= "Ya existe un usuario con ese nombre."; 
                }
            //Muestra de posibles errores    
            }catch(PDOException $miExceptionPDO){
                echo "Error: ".$miExceptionPDO->getMessage();
                 echo "<br>";
                echo "Código de error: ".$miExceptionPDO->getCode();
            }finally{
                unset($miDB);
            }
            
        }
       $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 3, 1);
       $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 8, 4, 1, 1);
       if($_REQUEST['confirmarPassword']!=$_REQUEST['password']){
           $aErrores['confirmarPassword']="Las contraseñas no coinciden.";
       }
       foreach($aErrores as $clave => $error){
            //condición de que hay un error
            if(($error)!=null){
                //limpieza del campo para cuando vuelva a aparecer el formulario
                $_REQUEST[$clave]="";
                $entradaOK=false;
            }
        }
   }
   else{
       $entradaOK=false;
   }
   if($entradaOK){
        $aRespuestas['nombreUsuario'] = $_REQUEST['nombreUsuario'];
        $aRespuestas['descUsuario'] = $_REQUEST['descUsuario'];
        $aRespuestas['password'] = $_REQUEST['password'];
        $passwordEncriptada = hash('sha256',$_REQUEST['nombreUsuario'].$_REQUEST['password']);
        try{
            //Establecimiento de la conexión 
            $miDB = new PDO(HOST, USER, PASSWORD);

            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Preparación de la consulta
            $oConsulta = $miDB->prepare(<<<QUERY
                    INSERT INTO T01_Usuario
                    VALUES ('{$_REQUEST['nombreUsuario']}',
                            '{$passwordEncriptada}',
                            '{$_REQUEST['descUsuario']}',
                            null,1,'usuario',null)
            QUERY);
            //Ejecución de la consulta de actualización
            if($oConsulta->execute($aColumnas)){
                session_start();
                $_SESSION['usuario214LoginLogout'] = $aRespuestas['nombreUsuario'];
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
   else{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <form action="registro.php">
            <fieldset>
                <table>
                    <tr>
                        <td>
                            <label for="nombreUsuario">Nombre de usuario<span>*</span>: </label>
                        </td>
                        <td>
                            <input type="text" name="nombreUsuario">
                        </td>
                        <?php
                            echo (!is_null($aErrores['nombreUsuario']))?"<td>$aErrores[nombreUsuario]</td>":"";
                        ?>        
                    </tr>
                    <tr>
                        <td>
                            <label for="descUsuario">Nombre completo<span>*</span>: </label>
                        </td>
                        <td>
                            <input type="text" name="descUsuario">
                        </td>
                        <?php
                            echo (!is_null($aErrores['descUsuario']))?"<td>$aErrores[descUsuario]</td>":"";
                        ?>    
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Contraseña<span>*</span>: </label>
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
                            <label for="confirmarPassword">Confirmar contraseña<span>*</span>: </label>
                        </td>
                        <td>
                            <input type="password" name="confirmarPassword">
                        </td>
                        <?php
                            echo (!is_null($aErrores['confirmarPassword']))?"<td>$aErrores[confirmarPassword]</td>":"";
                        ?>    
                    </tr>
                </table>
                <input class="boton" type="submit" name="registrarse" value="Registrarse"> 
            </fieldset>
        </form>
    </body>
</html>
<?php
   }
?>