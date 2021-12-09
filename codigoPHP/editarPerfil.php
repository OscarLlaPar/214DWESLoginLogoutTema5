<?php
    /*
        * Ventana de Editar Perfil
        * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
        * Última modificación: 07/12/2021
    */
    include "../config/confDB.php";
    include '../core/libreriaValidacion.php';
    $entradaOK = true; //Inicialización de la variable que nos indica que todo va bien
    session_start();
    $aErrores = [
       'nombreUsuario'=>null,
       'descUsuario'=>null
   ];
   $aRespuestas = [
       'nombreUsuario'=>null,
       'descUsuario'=>null
   ];
   if(isset($_REQUEST['cancelarEliminar'])){
       header('Location: editarPerfil.php');
       exit;
   }
   if(isset($_REQUEST['aceptarEliminar'])){
       try{
            //Establecimiento de la conexión 
            $miDB = new PDO(HOST, USER, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Preparación de la consulta
            $oConsulta = $miDB->prepare(<<<QUERY
                    DELETE FROM T01_Usuario
                    WHERE T01_CodUsuario = '{$_SESSION['usuario214LoginLogout']}'
            QUERY);
            //Ejecución de la consulta de actualización
            if($oConsulta->execute()){
                session_destroy();
                header('Location: ../indexLoginLogoutTema5.php');
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
    if(!empty($_REQUEST['editar'])){
       $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 3, 1);
       foreach($aErrores as $error){
            //condición de que hay un error
            if(($error)!=null){
                //limpieza del campo para cuando vuelva a aparecer el formulario
                $_REQUEST[key($error)]="";
                $entradaOK=false;
            }
        }
        if($entradaOK){
            try{

                //Establecimiento de la conexión 
                $miDB = new PDO(HOST, USER, PASSWORD);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Preparación de la consulta
                $oConsulta = $miDB->prepare(<<<QUERY
                        UPDATE T01_Usuario
                        SET T01_DescUsuario = '{$_REQUEST['descUsuario']}'
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
    try{    
    //Establecimiento de la conexión 
    $miDB = new PDO(HOST, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Preparación y ejecución de las consultas creadas en la condición
        $oConsulta = $miDB->prepare(<<<QUERY
                    SELECT * FROM T01_Usuario
                    WHERE T01_CodUsuario = '{$_SESSION['usuario214LoginLogout']}'
            QUERY);

        $oConsulta->execute();
        //Carga del registro en una variableç
        $registroObjeto = $oConsulta->fetch(PDO::FETCH_OBJ);

        $aValores=[];
        //Recorrido del registro
        foreach ($registroObjeto as $clave => $valor) {
            $aValores[$clave]=$valor;
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
<html>
    <head>
        <meta charset="UTF-8">
        <title>Editar Perfil - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
            if(isset($_REQUEST['eliminar'])){
        ?>
        <form action="editarPerfil.php" method="post">
            <fieldset>
                <p>¿Estás seguro?</p>
                <button class="boton" type="submit" name="aceptarEliminar">Sí</button>
                <button class="boton" type="submit" name="cancelarEliminar">No</button>
            </fieldset>
        </form>
        <?php
            }
            else{
        ?>
        <header>
            <h1>Desarrollo Web en Entorno Servidor</h1>
            <h2>Tema 5</h2>
            <a href="programa.php"><div class="cuadro" id="arriba">&#60;</div></a>
        </header>
        <form action="editarPerfil.php" method="post">
            <fieldset>
                <table>
                    <tr>
                        <td>
                            <label for="nombreUsuario">Nombre de usuario: </label>
                        </td>
                        <td>
                            <input type="text" name="nombreUsuario" value="<?php echo $aValores['T01_CodUsuario'];?>"  disabled>
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
                            <input type="text" name="descUsuario" value="<?php echo $aValores['T01_DescUsuario'];?>" >
                        </td>
                        <?php
                            echo (!is_null($aErrores['descUsuario']))?"<td>$aErrores[descUsuario]</td>":"";
                        ?>    
                    </tr>
                </table>
                    <a class="boton" href="cambiarPassword.php">
                            Cambiar contraseña
                        </a>
                <input class="boton" type="submit" name="eliminar" value="Darse de baja">
                <br>
                <input class="boton" type="submit" name="editar" value="Aceptar"> 
            </fieldset>
        </form>
        
        <?php
            }
        ?>
    </body>
</html>
