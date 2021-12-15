<?php
    /*
        * Ventana de Login
        * @author Óscar Llamas Parra - oscar.llapar@educa.jcyl.es - https://github.com/OscarLlaPar
        * Última modificación: 01/12/2021
    */
    //Incluir configuración de la base de datos
    include "../config/confDB.php";
    //Incluir librería de validación
    include "../core/libreriaValidacion.php";
    $entradaOK=true; //Inicialización de la variable que nos indica que todo va bien
    //Array que almacenará las respuestas validadas
    $aRespuestas=[
        'usuario'=>null,
        'password'=>null
    ];
    //Creación de un objeto DateTime para uso posterior
    $oFechaHora=new DateTime();
    //Obtención del timestamp actual
    $timeStampActual=$oFechaHora->getTimestamp();
    //Si se ha pulsado el botón de login
    if(isset($_REQUEST['login'])){
        //La entrada no está bien si el nombre de usuario no cumple los requisitos
        if (validacionFormularios::comprobarAlfaNumerico($_REQUEST['usuario'], 8, 4, 1) || validacionFormularios::comprobarAlfaNumerico($_REQUEST['password'], 8, 4, 1)) {
            $entradaOK = false;
        }
        //Si el nombre de usuario pasa la validación
        else{
            try{
                //Conexión con la base de datos
                $miDB = new PDO(HOST, USER, PASSWORD);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //Creación de la consulta
                $consulta=<<<QUERY
                        SELECT T01_Password, T01_FechaHoraUltimaConexion FROM T01_Usuario
                        WHERE T01_CodUsuario ='$_REQUEST[usuario]'
                        QUERY;
                //Preparación de la consulta
                $resultadoConsulta = $miDB->prepare($consulta);
                //Ejecución de la consulta
                $resultadoConsulta->execute();
                //Carga del registro en una variable
                $oRegistro = $resultadoConsulta->fetchObject();
                //Si la combinación usuario-contraseña no coincide con la de la base de datos
                if(!$oRegistro || $oRegistro->T01_Password != hash('sha256', $_REQUEST['usuario'].$_REQUEST['password'])){

                    $entradaOK=false; //La entrada no está bien
                }
                else{
                    //Se obtiene el timestamp de la última conexión antes de cambiarla
                    $timeStampConexionAnterior = $oRegistro->T01_FechaHoraUltimaConexion; 
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
    //Si no se ha pulsado el botón de login
    else{
        $entradaOK=false;
    }
    //Si todo ha ido bien
    if($entradaOK){
        //Almacenar el usuario en el array de respuestas
        $aRespuestas=[
        'usuario'=>$_REQUEST['usuario']
    ];
        try{
            //Conexión con la base de datos
            $miDB = new PDO(HOST, USER, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Creación de la consulta
            $consultaUpdate=<<<QUERY
                    UPDATE T01_Usuario
                    SET T01_FechaHoraUltimaConexion={$timeStampActual},
                    T01_NumConexiones=T01_NumConexiones+1
                    WHERE T01_CodUsuario ='{$aRespuestas['usuario']}'
                    QUERY;
            //Preparación de la consulta
            $resultadoConsultaUpdate = $miDB->prepare($consultaUpdate);
            //Eecución de la consulta
            $resultadoConsultaUpdate->execute();   
        //Gestión de errores relacionados con la base de datos
        } catch(PDOException $miExceptionPDO){
            echo "Error: ".$miExceptionPDO->getMessage();
            echo "<br>";
            echo "Código de error: ".$miExceptionPDO->getCode();
        }
        finally{
         //Cerrar la conexión
         unset($miDB);
        }
        //Creación de la sesión
        session_start();
        //Almacenar nombre de usuario y conexión anterior en la sesión
        $_SESSION['usuario214LoginLogout'] = $aRespuestas['usuario'];
        $_SESSION['conexionAnterior'] = $timeStampConexionAnterior;
        //Llevar al usuario al programa
        header("Location: programa.php");
    }
    //Si hay que cargar el formulario de login
    else{
        //Array con los saludos en distintos idiomas
        $aIdiomas=[
            "Bienvenido/a", "Welcome", "Velkommen", "어서 오십시오"  
        ];
        //Array con imagenes y mensajes de los distintos gatos
        $aGatos=[
          'imagen' => [
              "../webroot/img/dd.jpg",
              "../webroot/img/tt.jpg",
              "../webroot/img/coco.jpg",
              "../webroot/img/momo.jpg",
              "../webroot/img/chuchu.jpg",
              "../webroot/img/lala.png",
              "../webroot/img/lulu.png",
              "../webroot/img/nana.jpg",
              "../webroot/img/toto.jpg",
              "../webroot/img/dodo.jpg",
          ],
          'mensaje' => [
              "DD dice: \"DD es lindo. DD quiere pan.\"",
              "TT dice: \"Yo soy la reina\"",
              "CoCo dice: \"Hmm... Interesante uso de las cookies...\"",
              "MoMo dice: \"En mi juventud yo tambien hice muchos LoginLogout.\"",
              "ChuChu dice: \"¿Chu? Chu...\"",
              "LaLa dice: \"¡¡Myah, myah!!\"",
              "LuLu dice: \"Perdone, soy LuLu, ¿puedo comer una cookie?\"",
              "NaNa dice: \"¡¡Yo solo quiero amor!!\"",
              "Toto dice: *beep-beep*",
              "DoDo dice: \"¿LoginLogout? ¿Eso es comida?\"",
          ]
        ];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login - LoginLogout</title>
        <link href="../webroot/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <h1>Login</h1>
            <?php echo $aIdiomas[$_COOKIE['idioma']]?>
            <a href="../indexLoginLogoutTema5.php"><div class="cuadro" id="arriba">&#60;</div></a>
        </header>
        <main class="mainLogin">
            
            <div class="login">
                <form name="login" action="login.php" method="get">
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
                        <input class="boton" id="entrar" type="submit" name="login" value="Entrar">
                </form>
                <p>¿No tienes cuenta? <a href="registro.php">Regístrate</a></p>
            </div>
            <div class="gato">
                <?php echo "<img src=\"".$aGatos['imagen'][$_COOKIE['gato']]."\"";?>
                <p><?php echo $aGatos['mensaje'][$_COOKIE['gato']]?></p>
            </div>
        </main>
    </body>
</html>
<?php
}
?>
