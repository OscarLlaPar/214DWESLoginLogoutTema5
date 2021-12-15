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
    //Si no hay sesión
    if (!isset($_SESSION['usuario214LoginLogout'])) {
        header('Location: login.php'); //Regresar al login
    }
    //Inicializar el array de mensajes de error
    $aErrores = [
       'nombreUsuario'=>null,
       'descUsuario'=>null,
       'imagenUsuario'=>null
   ];
    //Si se ha pulsado el botón de cancelar
   if(!empty($_REQUEST['cancelar'])){
       header('Location: programa.php'); //Volver atrás
   }
    //Si se pulsa el boton cancelar al eliminar
   if(isset($_REQUEST['cancelarEliminar'])){
       header('Location: editarPerfil.php'); //Se vuelve a la página de editar perfil
       exit;
   }
   //Si se pulsa el botón de aceptar al eliminar
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
            //Ejecución de la consulta de actualización - Si se ejecuta...
            if($oConsulta->execute()){
                session_destroy(); //Terminar la sesión
                header('Location: ../indexLoginLogoutTema5.php'); //Volver a la página de inicio
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
        //Carga del registro en una variable
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
    if(!empty($_REQUEST['aceptar'])){
       $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 3, 1); //Validación de la descripción introducida
       $aErrores['imagenUsuario'] = validacionFormularios::comprobarAlfaNumerico($_FILES['imagenUsuario']['name'], 255, 3, 0); //Validación del nombre del archivo de imagen
       //Si se ha validado el nombre de la imagen
       if($aErrores['imagenUsuario']==null && !empty($_FILES['imagenUsuario']['name'])){
           $aExtensiones = ['jpg', 'jpeg', 'png']; //Array de extensiones válidas
           $extension = substr($_FILES['imagenUsuario']['name'], strpos($_FILES['imagenUsuario']['name'], '.') + 1); //Se extrae la extensión del nombre del archivo
           //Si la extensión extraída no coincide con ninguna de las del array
           if (!in_array($extension, $aExtensiones)) {
                $aErrores['imagenUsuario'] = "El archivo no tiene una extensión válida. Sólo se admite ".implode(', ', $aExtensiones)."."; //Creación del mensaje de error
            }
           
       }
       //Recorrido de errores de los campos
       foreach($aErrores as $error){
            //condición de que hay un error
            if(($error)!=null){
                $entradaOK=false; //La entrada está mal
            }
        }
        //Si todo ha ido bien
        if($entradaOK){
            //Si se ha especificado imagen de usuario
            if($_FILES['imagenUsuario']['name'] != ''){
                $imagenUsuario = base64_encode(file_get_contents($_FILES['imagenUsuario']['tmp_name'])); //Almacenamiento del fichero enviado
            }
            //Si no se ha especificado imagen
            else{
                $imagenUsuario =$aValores['T01_ImagenUsuario']; //Asignación de la imagen que había antes
            }
            //Conexión a la BD para efectuar los cambios
            try{

                //Establecimiento de la conexión 
                $miDB = new PDO(HOST, USER, PASSWORD);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Preparación de la consulta
                $oConsulta = $miDB->prepare(<<<QUERY
                        UPDATE T01_Usuario
                        SET T01_DescUsuario = '{$_REQUEST['descUsuario']}',
                        T01_ImagenUsuario = '{$imagenUsuario}'
                        WHERE T01_CodUsuario = '{$_SESSION['usuario214LoginLogout']}'
                QUERY);
                //Ejecución de la consulta de actualización - Si se ejecuta...
                if($oConsulta->execute()){
                    header('Location: programa.php'); //Regreso al programa
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
        </header>
        <form action="editarPerfil.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <table>
                    <tr>
                        <td>
                            <label for="nombreUsuario">Nombre de usuario: </label>
                        </td>
                        <td>
                            <input type="text" name="nombreUsuario" value="<?php echo $aValores['T01_CodUsuario'];?>"  disabled>
                        </td>    
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
                    <tr>
                        <td>
                            <label for="fechaHoraUltimaConexion">Última conexión: </label>
                        </td>
                        <td>
                            <input type="text" name="fechaHoraUltimaConexion" value="<?php echo date('\E\l d/m/Y \a \l\a\s H:i:s', $aValores['T01_FechaHoraUltimaConexion']);?>"  disabled>
                        </td>    
                    </tr>
                    <tr>
                        <td>
                            <label for="numConexiones">Veces conectado: </label>
                        </td>
                        <td>
                            <input type="text" name="numConexiones" value="<?php echo $aValores['T01_NumConexiones'];?>"  disabled>
                        </td>    
                    </tr>
                    <tr>
                        <td>
                            <label for="perfil">Perfil: </label>
                        </td>
                        <td>
                            <input type="text" name="perfil" value="<?php echo $aValores['T01_Perfil'];?>"  disabled>
                        </td>    
                    </tr>
                    <tr>
                        <td>
                            <label for="imagenUsuario">Imagen del usuario (.png, .jpg): </label>
                            <br>
                            <?php
                                if(isset($aValores['T01_ImagenUsuario'])){
                            ?>
                            <img class="fotoPerfil" src="data:image/gif;base64, <?php echo $aValores['T01_ImagenUsuario'] ?>" alt="Foto de perfil">
                            <?php
                                }
                            ?>
                        </td>
                        <td>
                            <input type="file" name="imagenUsuario">
                        </td>    
                        <?php
                            echo (!is_null($aErrores['imagenUsuario']))?"<td>$aErrores[imagenUsuario]</td>":"";
                        ?>    
                    </tr>
                </table>
                <table>
                    <tr>
                        <td><input class="boton" type="submit" name="aceptar" value="Aceptar"></td>
                        <td><input class="boton" type="submit" name="cancelar" value="Cancelar"> </td>
                    </tr>
                    <tr>
                        <td><a class="boton" href="cambiarPassword.php">Cambiar contraseña</a></td>
                        <td><input class="boton" type="submit" name="eliminar" value="Darse de baja"></td>
                    </tr>
                    
                </table>
                
                
            </fieldset>
        </form>
        
        <?php
            }
        ?>
    </body>
</html>
